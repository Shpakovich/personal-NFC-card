<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Repository\ProfileRepository;
use App\Model\UseCase\User\Profile\Create;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @param \App\Model\UseCase\User\Profile\Create\Command $command
     * @param \App\Model\UseCase\User\Profile\Create\Handler $handler
     * @param \App\Model\Repository\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Create\Command $command, Create\Handler $handler, ProfileRepository $profiles): JsonResponse
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->id = Id::next()->getValue();
        $command->userId = $user->getId();
        $handler->handle($command);

        $profile = $profiles->getById(new Id($command->id));
        $card = $profile->getCard();

        return $this->json(
            [
                'id' => $profile->getId()->getValue(),
                'user' => $profile->getUser()->getId()->getValue(),
                'card' => $card !== null ? $card->getId()->getValue() : null,
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
