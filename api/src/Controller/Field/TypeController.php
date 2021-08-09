<?php

declare(strict_types=1);

namespace App\Controller\Field;

use App\Controller\Guid;
use App\Controller\PaginationSerializer;
use App\Fetcher\Field\TypeFetcher;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Field\TypeRepository;
use App\Model\UseCase\Field\Type;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/field/type", name="field.type")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @OA\Get(
     *     summary="Получить список всех типов полей"
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
     *         @OA\Property(property="items", type="array", description="Список типов",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", description="ID"),
     *                 @OA\Property(property="name", type="string", description="Название типа"),
     *                 @OA\Property(property="sort", type="integer", description="Порядок вывода на фронте"),
     *                 @OA\Property(property="created_at", type="string", description="Дата создания"),
     *                 @OA\Property(property="updated_at", type="string", description="Дата измения"),
     *                 @OA\Property(property="creator", type="object", description="Кто создал"),
     *                 @OA\Property(property="editor", type="object", description="Кто обновил")
     *             )
     *         ),
     *         @OA\Property(property="pagination", ref=@Model(type=\App\Controller\PaginationSerializer::class))
     *     )
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Field types")
     * @Security(name="Bearer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\Field\TypeFetcher $fetcher
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, TypeFetcher $fetcher): JsonResponse
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
                            'name' => $item['name'],
                            'sort' => $item['sort'],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at'],
                            'creator' => [
                                'id' => $item['creator_id'],
                                'email' => $item['creator_email'],
                            ],
                            'editor' => [
                                'id' => $item['editor_id'],
                                'email' => $item['editor_email'],
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
     *     summary="Получить информацию по типу по его ID"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID типа",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\Response(response=200, description="OK")
     * @OA\Response(response=404, description="Не найден")
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Field types")
     * @Security(name="Bearer")
     *
     * @param \App\Model\Entity\Field\Type $type
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(\App\Model\Entity\Field\Type $type): JsonResponse
    {
        return $this->json(
            [
                'id' => $type->getId()->getValue(),
                'name' => $type->getName(),
                'sort' => $type->getSort(),
                'created_at' => $type->getCreatedAt()->format(\DateTimeInterface::RFC3339),
                'updated_at' => $type->getUpdatedAt()->format(\DateTimeInterface::RFC3339),
                'creator' => [
                    'id' => $type->getCreator()->getId()->getValue(),
                    'email' => $type->getCreator()->getEmail()->getValue(),
                ],
                'editor' => [
                    'id' => $type->getEditor()->getId()->getValue(),
                    'email' => $type->getEditor()->getEmail()->getValue(),
                ]
            ]
        );
    }

    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @OA\Post(
     *     summary="Создать тип поля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name", "order"},
     *              @OA\Property(property="name", type="string", description="Название типа"),
     *              @OA\Property(property="sort", type="integer", description="Порядок вывода в профиле пользователя")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Тип создан",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string"),
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="sort", type="integer"),
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
     * @OA\Tag(name="Field types")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Field\Type\Create\Command $command
     * @param \App\Model\UseCase\Field\Type\Create\Handler $handler
     * @param \App\Model\Repository\Field\TypeRepository $types
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Type\Create\Command $command,
        Type\Create\Handler $handler,
        TypeRepository $types
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->id = Id::next()->getValue();
        $command->userId = $user->getId();
        $handler->handle($command);

        $type = $types->getById(new Id($command->id));

        return $this->json(
            [
                'id' => $type->getId()->getValue(),
                'name' => $type->getName(),
                'sort' => $type->getSort(),
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/delete", methods={"POST"}, name=".delete")
     *
     * @OA\Post(
     *     summary="Удалить тип",
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
     *     description="Карта удалена"
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
     * @OA\Tag(name="Field types")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Field\Type\Delete\Command $command
     * @param \App\Model\UseCase\Field\Type\Delete\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(
        Type\Delete\Command $command,
        Type\Delete\Handler $handler
    ): JsonResponse {
        $handler->handle($command);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/edit", methods={"POST"}, name=".edit")
     *
     * @OA\Post(
     *     summary="Изменить тип поля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name", "order"},
     *              @OA\Property(property="id", type="string", description="ID типа"),
     *              @OA\Property(property="name", type="string", description="Название типа"),
     *              @OA\Property(property="sort", type="integer", description="Порядок вывода в профиле пользователя")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Тип изменен",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string"),
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="sort", type="integer"),
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
     * @OA\Tag(name="Field types")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Field\Type\Edit\Command $command
     * @param \App\Model\UseCase\Field\Type\Edit\Handler $handler
     * @param \App\Model\Repository\Field\TypeRepository $types
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function edit(
        Type\Edit\Command $command,
        Type\Edit\Handler $handler,
        TypeRepository $types
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        $type = $types->getById(new Id($command->id));

        return $this->json(
            [
                'id' => $type->getId()->getValue(),
                'name' => $type->getName(),
                'sort' => $type->getSort(),
            ],
            Response::HTTP_OK
        );
    }
}
