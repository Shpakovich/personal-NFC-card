<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Repository\ProfileRepository;
use App\Model\UseCase\User\Profile\Create;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\UseCase\User\Profile\Create\Handler $handler
     * @param \App\Model\Repository\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request, Create\Handler $handler, ProfileRepository $profiles): JsonResponse
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        /** @var string $content */
        $content = $request->getContent();

        /** @var \App\Model\UseCase\User\Profile\Create\Command $command */
        $command = $this->serializer->deserialize(
            $content,
            Create\Command::class,
            JsonEncoder::FORMAT,
            [
                'object_to_populate' => new Create\Command(Id::next()->getValue(), $user->getId()),
                'ignored_attributes' => ['id', 'userId'],
            ]
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, JsonEncoder::FORMAT);
            return new JsonResponse($json, 422, [], true);
        }

        $handler->handle($command);

        $profile = $profiles->getById(new Id($command->id));


        return $this->json(
            [
                'id' => $profile->getId()->getValue(),
                'user' => $profile->getUser()->getId()->getValue(),
                'card' => $profile->getCard() ? $profile->getCard()->getId()->getValue() : null,
                'title' => $profile->getTitle(),
                'name' => $profile->getName(),
                'nickname' => $profile->getNickname(),
                'default_name' => $profile->getDefaultName(),
                'post' => $profile->getPost(),
                'description' => $profile->getDescription(),
                'is_published' => $profile->isPublished(),
                'created_at' => $profile->getCreatedAt()->format(DateTimeInterface::RFC3339),
            ],
            201
        );
    }
}
