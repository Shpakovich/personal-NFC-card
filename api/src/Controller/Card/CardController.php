<?php

declare(strict_types=1);

namespace App\Controller\Card;

use App\Controller\Guid;
use App\Controller\PaginationSerializer;
use App\Fetcher\CardFetcher;
use App\Model\Entity\Card\Id;
use App\Model\Repository\CardRepository;
use App\Model\UseCase\Card;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\CardFetcher $fetcher
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, CardFetcher $fetcher): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $perPage = $this->getParameter('app.items_per_page');
        $pagination = $fetcher->all($page, $perPage);

        return $this->json(
            [
                'items' => array_map(
                    static function (array $item) {
                        return [
                            'id' => $item['id'],
                            'created_at' => $item['created_at'],
                            'user_id' => $item['user_id'],
                            'user_email' => $item['user_email'],
                        ];
                    },
                    (array)$pagination->getItems()
                ),
                'pagination' => PaginationSerializer::serialize($pagination),
            ]
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name=".show", requirements={
     *     "id"=Guid::PATTERN
     * })
     *
     * @param \App\Model\Entity\Card\Card $card
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function card(\App\Model\Entity\Card\Card $card): JsonResponse
    {
        return $this->json(
            [
                'id' => $card->getId()->getValue(),
                'created_at' => $card->getCreatedAt()->format(DateTimeInterface::RFC3339),
                'creator_id' => $card->getCreator()->getId()->getValue()
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

        $card = $cards->getById(new Id($command->id));

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
