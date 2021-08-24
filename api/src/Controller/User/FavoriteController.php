<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\PaginationSerializer;
use App\Fetcher\User;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Profile;
use App\Model\Entity\User\Role;
use App\Model\Repository\FavoriteRepository;
use App\Model\Service\Storage\Storage;
use App\Model\UseCase\User\Favorite;
use App\Security\Voter\User\FavoriteAccess;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/favorite", name="user.favorite")
 */
class FavoriteController extends AbstractController
{
    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @OA\Get(
     *     summary="Получить список избранных профилей."
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
     *                 @OA\Property(property="user", type="object", description="Пользователь",
     *                     @OA\Property(property="id", type="string", description="ID"),
     *                     @OA\Property(property="email", type="string", description="Email")
     *                 ),
     *                 @OA\Property(property="profile", type="object", description="Профиль",
     *                     @OA\Property(property="id", type="string", description="ID"),
     *                     @OA\Property(property="name", type="string", description="Имя"),
     *                     @OA\Property(property="post", type="string", description="Должность"),
     *                     @OA\Property(property="photo", type="object", description="Фотография",
     *                         @OA\Property(property="path", type="string", description="Путь до фотографии")
     *                     )
     *                 )
     *             )
     *         ),
     *         @OA\Property(property="pagination", ref=@Model(type=\App\Controller\PaginationSerializer::class))
     *     )
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     *
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\User\FavoriteFetcher $fetcher
     * @param \App\Model\Service\Storage\Storage $storage
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, User\FavoriteFetcher $fetcher, Storage $storage): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        /** @var int $perPage */
        $perPage = $this->getParameter('app.items_per_page');

        if ($this->isGranted(Role::ADMIN)) {
            $pagination = $fetcher->all($page, $perPage);
        } else {
            /** @var \App\Security\UserIdentity $user */
            $user = $this->getUser();
            $pagination = $fetcher->all($page, $perPage, $user->getId());
        }

        return $this->json(
            [
                'items' => array_map(
                    static function (array $item) use ($storage) {
                        if ($item['profile_default_name'] === Profile::DEFAULT_NAME) {
                            /** @var string $name */
                            $name = $item['profile_name'];
                        } else {
                            /** @var string $name */
                            $name = $item['profile_nickname'];
                        }

                        $photo = null;
                        /** @var string $path */
                        $path = $item['profile_photo_path'];
                        if (!empty($path)) {
                            $photo = [
                                'path' => $storage->url($path),
                            ];
                        }

                        return [
                            'id' => $item['id'],
                            'user' => [
                                'id' => $item['user_id'],
                                'email' => $item['user_email'],
                            ],
                            'profile' => [
                                'id' => $item['profile_id'],
                                'name' => $name,
                                'post' => $item['post'],
                                'photo' => $photo,
                            ]
                        ];
                    },
                    (array)$pagination->getItems()
                ),
                'pagination' => PaginationSerializer::serialize($pagination)
            ]
        );
    }

    /**
     * @Route("/add", methods={"POST"}, name=".add")
     *
     * @OA\Post(
     *     summary="Добавить профиль в избранное",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"profile_id"},
     *              @OA\Property(property="id", type="string", description="ID профиля")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Профиль добавлен в избранное"
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
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\User\Favorite\Add\Command $command
     * @param \App\Model\UseCase\User\Favorite\Add\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(
        Favorite\Add\Command $command,
        Favorite\Add\Handler $handler
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->id = Id::next()->getValue();
        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([], 201);
    }

    /**
     * @Route("/delete", methods={"POST"}, name=".delete")
     *
     * @OA\Post(
     *     summary="Удалить профиль из избранного",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID удаляемого типа")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=204,
     *     description="Профиль удален из избанного"
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
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\User\Favorite\Delete\Command $command
     * @param \App\Model\UseCase\User\Favorite\Delete\Handler $handler
     * @param \App\Model\Repository\FavoriteRepository $favorites
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(
        Favorite\Delete\Command $command,
        Favorite\Delete\Handler $handler,
        FavoriteRepository $favorites
    ): JsonResponse {
        $favorite = $favorites->getById(new Id($command->id));
        $this->denyAccessUnlessGranted(FavoriteAccess::EDIT, $favorite);

        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();
        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
