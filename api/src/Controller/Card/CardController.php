<?php

declare(strict_types=1);

namespace App\Controller\Card;

use App\Model\Repository\CardRepository;
use App\Model\UseCase\Card;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/card", name="card")
 */
class CardController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        return $this->json(
            [
                ['id' => "00000000-0000-0000-0000-000000000000"],
                ['id' => "11111111-1111-1111-1111-111111111111"],
                ['id' => "22222222-2222-2222-2222-222222222222"],
                ['id' => "33333333-3333-3333-3333-333333333333"],
            ]
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name=".show")
     *
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function card(string $id): Response
    {
        if ($id !== '00000000-0000-0000-0000-000000000000') {
            throw new \DomainException('Card not found', 404);
        }

        return $this->json(
            [
                'id' => "00000000-0000-0000-0000-000000000000",
            ]
        );
    }

    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\UseCase\Card\Create\Handler $handler
     * @param \App\Model\Repository\CardRepository $cards
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request, Card\Create\Handler $handler, CardRepository $cards): JsonResponse
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        /** @var string $content */
        $content = $request->getContent();

        /** @var \App\Model\UseCase\Card\Create\Command $command */
        $command = $this->serializer->deserialize(
            $content,
            Card\Create\Command::class,
            'json',
            [
                'object_to_populate' => new Card\Create\Command($user->getId()),
                'ignored_attributes' => ['userId'],
            ]
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 422, [], true);
        }

        $handler->handle($command);

        $card = $cards->getById(new \App\Model\Entity\Card\Id($command->id));

        return $this->json(
            [
                'id' => $card->getId()->getValue(),
                'created_at' => $card->getCreatedAt()->format(DateTimeInterface::RFC3339),
                'creator_id' => $card->getCreator()->getId()->getValue()
            ],
            201
        );
    }
}
