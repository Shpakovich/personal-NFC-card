<?php

declare(strict_types=1);

namespace App\Controller\Field;

use App\Controller\Guid;
use App\Controller\PaginationSerializer;
use App\Fetcher\Field\FieldFetcher;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Field as FiledEntity;
use App\Model\Repository\Field\FieldRepository;
use App\Model\Service\Storage\Storage;
use App\Model\UseCase\Field\Field;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/field", name="field")
 */
class FieldController extends AbstractController
{
    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @OA\Get(
     *     summary="Получить список всех полей"
     * )
     *
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Номер страницы в пагинации.",
     *     @OA\Schema(type="integer")
     * )
     *
     * @OA\Parameter(
     *     name="type_id",
     *     in="query",
     *     description="ID типа",
     *     required=false,
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         @OA\Property(property="items", type="array", description="Список полей",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", description="ID"),
     *                 @OA\Property(property="title", type="string", description="Заголовок"),
     *                 @OA\Property(property="color", type="object", description="Цвета",
     *                     @OA\Property(property="bg", type="string", description="Цвет фона"),
     *                     @OA\Property(property="text", type="string", description="Цвет текста")
     *                 ),
     *                 @OA\Property(property="icon", type="object", description="Иконка",
     *                     @OA\Property(property="path", type="string", description="Путь до картинки")
     *                 ),
     *                 @OA\Property(property="help", type="string", description="Поясняющий текст"),
     *                 @OA\Property(property="type", type="object", description="Тип поля",
     *                     @OA\Property(property="id", type="string", description="ID"),
     *                     @OA\Property(property="name", type="string", description="Название"),
     *                     @OA\Property(property="sort", type="string", description="Порядок вывода"),
     *                 ),
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
     *
     * @OA\Tag(name="Fields")
     * @Security(name="Bearer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\Field\FieldFetcher $fetcher
     * @param \App\Model\Service\Storage\Storage $storage
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, FieldFetcher $fetcher, Storage $storage): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        /** @var int $perPage */
        $perPage = $this->getParameter('app.items_per_page');

        /** @var string $typeId */
        $typeId = $request->query->get('type_id');
        $pagination = $fetcher->all($page, $perPage, $typeId);

        return $this->json(
            [
                'items' => array_map(
                    static function (array $item) use ($storage) {
                        $icon = null;
                        /** @var null|string $path */
                        $path = $item['icon_path'];
                        if (!empty($path)) {
                            $icon = [
                                'path' => $storage->url($path),
                            ];
                        }

                        return [
                            'id' => $item['id'],
                            'title' => $item['title'],
                            'color' => [
                                'bg' => $item['bg_color'],
                                'text' => $item['text_color'],
                            ],
                            'icon' => $icon,
                            'help' => $item['help'],
                            'type' => [
                                'id' => $item['type_id'],
                                'name' => $item['type_name'],
                                'sort' => $item['type_sort'],
                            ],
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
     *     summary="Получить информацию по полю по его ID"
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
     *
     * @OA\Tag(name="Fields")
     * @Security(name="Bearer")
     *
     * @param \App\Model\Entity\Field\Field $field
     * @param \App\Model\Service\Storage\Storage $storage
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(FiledEntity $field, Storage $storage): JsonResponse
    {
        $type = $field->getType();
        $creator = $field->getCreator();
        $editor = $field->getEditor();

        $icon = null;
        $path = $field->getIconPath();
        if (!empty($path)) {
            $icon = [
                'path' => $storage->url($path),
            ];
        }

        return $this->json(
            [
                'id' => $field->getId()->getValue(),
                'title' => $field->getTitle(),
                'color' => [
                    'bg' => $field->getBgColor()->getValue(),
                    'text' => $field->getTextColor()->getValue(),
                ],
                'icon' => $icon,
                'help' => $field->getHelp(),
                'type' => [
                    'id' => $type->getId()->getValue(),
                    'name' => $type->getName(),
                    'sort' => $type->getSort(),
                ],
                'created_at' => $field->getCreatedAt()->format(\DateTimeInterface::RFC3339),
                'updated_at' => $field->getUpdatedAt()->format(\DateTimeInterface::RFC3339),
                'creator' => [
                    'id' => $creator->getId()->getValue(),
                    'email' => $creator->getEmail()->getValue(),
                ],
                'editor' => [
                    'id' => $editor->getId()->getValue(),
                    'email' => $editor->getEmail()->getValue(),
                ]
            ]
        );
    }

    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @OA\Post(
     *     summary="Создать поле",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"title", "bg_color", "text_color", "type_id"},
     *              @OA\Property(property="title", type="string", description="Название"),
     *              @OA\Property(property="bg_color", type="string", description="Цвет фона"),
     *              @OA\Property(property="text_color", type="string", description="Цвет текста"),
     *              @OA\Property(property="help", type="string", description="Поясняющий текст"),
     *              @OA\Property(property="type_id", type="string", description="ID типа")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Поле создано",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID"),
     *         @OA\Property(property="title", type="string", description="Заголовок"),
     *         @OA\Property(property="color", type="object", description="Цвета",
     *             @OA\Property(property="bg", type="string", description="Цвет фона"),
     *             @OA\Property(property="text", type="string", description="Цвет текста")
     *         ),
     *         @OA\Property(property="icon", type="object", description="Иконка",
     *             @OA\Property(property="path", type="string", description="Путь до картинки")
     *         ),
     *         @OA\Property(property="help", type="string", description="Поясняющий текст"),
     *         @OA\Property(property="type", type="object", description="Тип поля",
     *             @OA\Property(property="id", type="string", description="ID"),
     *             @OA\Property(property="name", type="string", description="Название"),
     *             @OA\Property(property="sort", type="string", description="Порядок вывода"),
     *         )
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
     * @OA\Tag(name="Fields")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Field\Field\Create\Command $command
     * @param \App\Model\UseCase\Field\Field\Create\Handler $handler
     * @param \App\Model\Repository\Field\FieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Field\Create\Command $command,
        Field\Create\Handler $handler,
        FieldRepository $fields
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->id = Id::next()->getValue();
        $command->userId = $user->getId();
        $handler->handle($command);

        $field = $fields->getById(new Id($command->id));
        $type = $field->getType();

        return $this->json(
            [
                'id' => $field->getId()->getValue(),
                'title' => $field->getTitle(),
                'color' => [
                    'bg' => $field->getBgColor()->getValue(),
                    'text' => $field->getTextColor()->getValue(),
                ],
                'icon' => [
                    'path' => $field->getIconPath()
                ],
                'help' => $field->getHelp(),
                'type' => [
                    'id' => $type->getId()->getValue(),
                    'name' => $type->getName(),
                    'sort' => $type->getSort(),
                ]
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/delete", methods={"POST"}, name=".delete")
     *
     * @OA\Post(
     *     summary="Удалить поле",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID удаляемого поля")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=204,
     *     description="Поле удалено"
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
     * @OA\Tag(name="Fields")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Field\Field\Delete\Command $command
     * @param \App\Model\UseCase\Field\Field\Delete\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(
        Field\Delete\Command $command,
        Field\Delete\Handler $handler
    ): JsonResponse {
        $handler->handle($command);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/edit", methods={"POST"}, name=".edit")
     *
     * @OA\Post(
     *     summary="Изменить поле",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id", "title", "bg_color", "text_color", "type_id"},
     *              @OA\Property(property="id", type="string", description="ID"),
     *              @OA\Property(property="title", type="string", description="Название"),
     *              @OA\Property(property="bg_color", type="string", description="Цвет фона"),
     *              @OA\Property(property="text_color", type="string", description="Цвет текста"),
     *              @OA\Property(property="help", type="string", description="Поясняющий текст"),
     *              @OA\Property(property="type_id", type="string", description="ID типа")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Поле изменено",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID"),
     *         @OA\Property(property="title", type="string", description="Заголовок"),
     *         @OA\Property(property="color", type="object", description="Цвета",
     *             @OA\Property(property="bg", type="string", description="Цвет фона"),
     *             @OA\Property(property="text", type="string", description="Цвет текста")
     *         ),
     *         @OA\Property(property="icon", type="object", description="Иконка",
     *             @OA\Property(property="path", type="string", description="Путь до картинки")
     *         ),
     *         @OA\Property(property="help", type="string", description="Поясняющий текст"),
     *         @OA\Property(property="type", type="object", description="Тип поля",
     *             @OA\Property(property="id", type="string", description="ID"),
     *             @OA\Property(property="name", type="string", description="Название"),
     *             @OA\Property(property="sort", type="string", description="Порядок вывода"),
     *         )
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
     * @OA\Tag(name="Fields")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Field\Field\Edit\Command $command
     * @param \App\Model\UseCase\Field\Field\Edit\Handler $handler
     * @param \App\Model\Repository\Field\FieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function edit(
        Field\Edit\Command $command,
        Field\Edit\Handler $handler,
        FieldRepository $fields
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        $field = $fields->getById(new Id($command->id));
        $type = $field->getType();

        return $this->json(
            [
                'id' => $field->getId()->getValue(),
                'title' => $field->getTitle(),
                'color' => [
                    'bg' => $field->getBgColor()->getValue(),
                    'text' => $field->getTextColor()->getValue(),
                ],
                'icon' => [
                    'path' => $field->getIconPath()
                ],
                'help' => $field->getHelp(),
                'type' => [
                    'id' => $type->getId()->getValue(),
                    'name' => $type->getName(),
                    'sort' => $type->getSort(),
                ]
            ],
            Response::HTTP_OK
        );
    }
}
