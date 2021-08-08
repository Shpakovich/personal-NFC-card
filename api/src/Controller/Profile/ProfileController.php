<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Controller\PaginationSerializer;
use App\Fetcher\Profile\Profile\ProfileFetcher;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\UseCase\Profile;
use DateTimeInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @OA\Get(
     *     summary="Получить список профилей"
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
     *         @OA\Property(property="items", type="array", description="Список профилей",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", description="ID"),
     *                 @OA\Property(property="title", type="string", description="Заголовок"),
     *                 @OA\Property(property="name", type="string", description="Имя"),
     *                 @OA\Property(property="nickname", type="string", description="Никнейм"),
     *                 @OA\Property(property="default_name", type="integer", description="Имя по умолчанию"),
     *                 @OA\Property(property="post", type="string", description="Должность"),
     *                 @OA\Property(property="description", type="string", description="Описание"),
     *                 @OA\Property(property="is_published", type="boolean", description="Опубликован или нет"),
     *                 @OA\Property(property="photo", type="object", description="Цвета",
     *                     @OA\Property(property="path", type="string", description="Путь до фотографии")
     *                 ),
     *                 @OA\Property(property="card", type="object", description="Карта",
     *                     @OA\Property(property="id", type="string", description="ID"),
     *                     @OA\Property(property="alias", type="string", description="Псевдоним"),
     *                 ),
     *                 @OA\Property(property="user", type="object", description="Пользователь",
     *                     @OA\Property(property="id", type="string", description="ID"),
     *                     @OA\Property(property="email", type="string", description="Email")
     *                 ),
     *                 @OA\Property(property="created_at", type="string", description="Дата создания"),
     *                 @OA\Property(property="updated_at", type="string", description="Дата измения")
     *             )
     *         ),
     *         @OA\Property(property="pagination", ref=@Model(type=\App\Controller\PaginationSerializer::class))
     *     )
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     *
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\Profile\Profile\ProfileFetcher $fetcher
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, ProfileFetcher $fetcher): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        /** @var int $perPage */
        $perPage = $this->getParameter('app.items_per_page');
        $pagination = $fetcher->all($page, $perPage);

        return $this->json(
            [
                'items' => array_map(
                    static function (array $item) {
                        $card = null;
                        if (!empty($item['card_id'])) {
                            $card = [
                                'id' => $item['card_id'],
                                'alias' => $item['card_alias'],
                            ];
                        }

                        return [
                            'id' => $item['id'],
                            'title' => $item['title'],
                            'name' => $item['name'],
                            'nickname' => $item['nickname'],
                            'default_name' => $item['default_name'],
                            'post' => $item['post'],
                            'description' => $item['description'],
                            'is_published' => $item['is_published'],
                            'photo' => [
                                'path' => $item['photo_path']
                            ],
                            'card' => $card,
                            'user' => [
                                'id' => $item['user_id'],
                                'email' => $item['user_email'],
                            ],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at'],
                        ];
                    },
                    (array)$pagination->getItems()
                ),
                'pagination' => PaginationSerializer::serialize($pagination),
            ]
        );
    }

    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @OA\Post(
     *     summary="Создать профиль и привязать его к зарегистрированной карте (если указана)",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="title", type="string", description="Заголовок профиля"),
     *              @OA\Property(property="name", type="string", description="Имя"),
     *              @OA\Property(property="nickname", type="string", description="Никнейм"),
     *              @OA\Property(
     *                  property="default_name",
     *                  type="integer",
     *                  description="Имя по умолчанию: 1 - имя (по умолчанию), 2 - никнейм",
     *                  default=1
     *              ),
     *              @OA\Property(property="post", type="string", description="Должность"),
     *              @OA\Property(property="description", type="string", description="Описание"),
     *              @OA\Property(
     *                  property="card_id", type="string", description="ID зарегистрированной карты пользователя"
     *              ),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Профиль создан",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID профиля"),
     *         @OA\Property(property="user", type="string", description="ID пользователя"),
     *         @OA\Property(property="card", type="string", nullable=true, description="ID привязанной карты"),
     *         @OA\Property(property="title", type="string", description="Заголовок профиля"),
     *         @OA\Property(property="name", type="string", description="Имя"),
     *         @OA\Property(property="nickname", type="string", description="Никнейм"),
     *         @OA\Property(property="default_name", type="integer", description="Имя по умолчанию"),
     *         @OA\Property(property="post", type="string", description="Должность"),
     *         @OA\Property(property="description", type="string", description="Описание"),
     *         @OA\Property(property="is_published", type="boolean", description="Опубликован или нет"),
     *         @OA\Property(property="created_at", type="string", description="Дата создания")
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
     *
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\Create\Command $command
     * @param \App\Model\UseCase\Profile\Create\Handler $handler
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Profile\Create\Command $command,
        Profile\Create\Handler $handler,
        ProfileRepository $profiles
    ): JsonResponse {
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

    /**
     * @Route("/publish", methods={"POST"}, name=".publish")
     *
     * @OA\Post(
     *     summary="Опубликовать профиль",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID профиля")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Профиль опубликован"
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
     *
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\Publish\Command $command
     * @param \App\Model\UseCase\Profile\Publish\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function publish(
        Profile\Publish\Command $command,
        Profile\Publish\Handler $handler
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([]);
    }

    /**
     * @Route("/hide", methods={"POST"}, name=".hide")
     *
     * @OA\Post(
     *     summary="Скрыть профиль",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID профиля")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Профиль снят с публикации"
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
     *
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\Hide\Command $command
     * @param \App\Model\UseCase\Profile\Hide\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function hide(
        Profile\Hide\Command $command,
        Profile\Hide\Handler $handler
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([]);
    }
}
