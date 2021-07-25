<?php

declare(strict_types=1);

namespace App\Controller\Card;

use App\Controller\Guid;
use App\Controller\PaginationSerializer;
use App\Fetcher\CardFetcher;
use App\Model\Entity\Common\Id;
use App\Model\Repository\CardRepository;
use App\Model\Repository\UserCardRepository;
use App\Model\UseCase\Card;
use App\Model\UseCase\User\Card\Register;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/card", name="card")
 */
class CardController extends AbstractController
{
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
        /** @var int $perPage */
        $perPage = $this->getParameter('app.items_per_page');
        $pagination = $fetcher->all($page, $perPage);

        return $this->json(
            [
                'items' => array_map(
                    static function (array $item) {
                        return [
                            'id' => $item['id'],
                            'created_at' => $item['created_at'],
                            'creator' => [
                                'id' => $item['creator_id'],
                                'email' => $item['creator_email'],
                            ]
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
    public function show(\App\Model\Entity\Card\Card $card): JsonResponse
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
     * @param \App\Model\UseCase\Card\Create\Command $command
     * @param \App\Model\UseCase\Card\Create\Handler $handler
     * @param \App\Model\Repository\CardRepository $cards
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Card\Create\Command $command,
        Card\Create\Handler $handler,
        CardRepository $cards
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        $card = $cards->getById(new Id($command->id));

        return $this->json(
            [
                'id' => $card->getId()->getValue(),
                'created_at' => $card->getCreatedAt()->format(DateTimeInterface::RFC3339),
                'creator' => [
                    'id' => $card->getCreator()->getId()->getValue(),
                    'email' => $card->getCreator()->getEmail()->getValue(),
                ]
            ],
            201
        );
    }

    /**
     * @Route("/register", methods={"POST"}, name=".register")
     *
     * @param \App\Model\UseCase\User\Card\Register\Command $command
     * @param \App\Model\UseCase\User\Card\Register\Handler $handler
     * @param \App\Model\Repository\UserCardRepository $cards
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function register(
        Register\Command $command,
        Register\Handler $handler,
        UserCardRepository $cards
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        $card = $cards->getByCardId(new Id($command->id));

        return $this->json(
            [
                'id' => $card->getId()->getValue(),
                'card_id' => $card->getCard()->getId()->getValue(),
                'alias' => $card->getAlias(),
                'added_at' => $card->getAddedAt()->format(DateTimeInterface::RFC3339),
            ],
            201
        );
    }
}
