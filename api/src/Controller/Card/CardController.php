<?php

declare(strict_types=1);

namespace App\Controller\Card;

use App\Controller\Guid;
use App\Controller\PaginationSerializer;
use App\Fetcher\CardFetcher;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\CardRepository;
use App\Model\Repository\UserCardRepository;
use App\Model\UseCase\Card;
use App\Model\UseCase\User\Card\Register;
use DateTimeInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
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
     * @OA\Get(
     *     summary="Получить список всех заведенных карт"
     * )
     *
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Номер страницы в пагинации.",
     *     @OA\Schema(type="integer")
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         @OA\Property(property="items", type="array", description="Список карт",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", description="ID карты"),
     *                 @OA\Property(property="created_at", type="string", description="Дата создания"),
     *                 @OA\Property(property="creator", type="object", description="Кто создал"),
     *             )
     *         ),
     *         @OA\Property(property="pagination", ref=@Model(type=\App\Controller\PaginationSerializer::class))
     *     )
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Card")
     * @Security(name="Bearer")
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
     * @OA\Get(
     *     summary="Получить информацию по карте по ее ID"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID карты",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\Response(response=200, description="OK")
     * @OA\Response(response=404, description="Не найдена")
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Card")
     * @Security(name="Bearer")
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
     * @OA\Post(
     *     summary="Создать карту",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID карты")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Карта создана",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID созданной карты")
     *     )
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="Ошибки бизнес логики, например, пользователь не найден.",
     *     @OA\JsonContent(ref=@Model(type=Error\DomainError::class))
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="Ошибка валидации входных данных.",
     *     @OA\JsonContent(ref=@Model(type=Error\ValidationError::class))
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Card")
     * @Security(name="Bearer")
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
     * @Route("/generate", methods={"POST"}, name=".generate")
     *
     * @OA\Post(
     *     summary="Сгенерировать карты",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"count"},
     *              @OA\Property(property="count", type="integer", description="Количество карт")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Карты созданы",
     *     @OA\JsonContent(
     *         @OA\Property(property="count", type="integer", description="Количество созданных карт")
     *     )
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="Ошибки бизнес логики.",
     *     @OA\JsonContent(ref=@Model(type=Error\DomainError::class))
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="Ошибка валидации входных данных.",
     *     @OA\JsonContent(ref=@Model(type=Error\ValidationError::class))
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Card")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Card\Generate\Command $command
     * @param \App\Model\UseCase\Card\Generate\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function generate(
        Card\Generate\Command $command,
        Card\Generate\Handler $handler
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json(['count' => $command->count], 201);
    }

    /**
     * @Route("/register", methods={"POST"}, name=".register")
     *
     * @OA\Post(
     *     summary="Регистрация карты пользователем",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID карты"),
     *              @OA\Property(property="alias", type="string", description="Псевдоним карты"),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Карта зарегистрирована",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID регистрации"),
     *         @OA\Property(property="card_id", type="string", description="ID зарегистированной карты"),
     *         @OA\Property(
     *             property="alias", type="string", nullable=true, description="Псевдоним зарегистированной карты"
     *         ),
     *         @OA\Property(property="added_at", type="string", description="Дата регистрации карты"),
     *     )
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="Ошибки бизнес логики, например, пользователь не найден.",
     *     @OA\JsonContent(ref=@Model(type=Error\DomainError::class))
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="Ошибка валидации входных данных.",
     *     @OA\JsonContent(ref=@Model(type=Error\ValidationError::class))
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Card")
     * @Security(name="Bearer")
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
