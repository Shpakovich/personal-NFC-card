<?php

declare(strict_types=1);

namespace App\Controller\Theme;

use App\Controller\PaginationSerializer;
use App\Fetcher\Profile\Theme\ThemeFetcher;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\UseCase\Card;
use App\Model\UseCase\Profile\Theme;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/theme", name="theme")
 */
class ThemeController extends AbstractController
{
    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @OA\Get(
     *     summary="Получить список всех тем"
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
     *         @OA\Property(property="items", type="array", description="Список тем",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", description="ID"),
     *                 @OA\Property(property="name", type="string", description="Название"),
     *                 @OA\Property(property="code", type="string", description="Код"),
     *             )
     *         ),
     *         @OA\Property(property="pagination", ref=@Model(type=\App\Controller\PaginationSerializer::class))
     *     )
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Theme")
     * @Security(name="Bearer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\Profile\Theme\ThemeFetcher $fetcher
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, ThemeFetcher $fetcher): JsonResponse
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
                            'code' => $item['code']
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
     *     summary="Создать тему",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name", "code"},
     *              @OA\Property(property="name", type="string", description="Название"),
     *              @OA\Property(property="code", type="string", description="Код"),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Тема создана",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID"),
     *         @OA\Property(property="name", type="string", description="Название"),
     *         @OA\Property(property="code", type="string", description="Код")
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
     * @OA\Tag(name="Theme")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\Theme\Create\Command $command
     * @param \App\Model\UseCase\Profile\Theme\Create\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Theme\Create\Command $command,
        Theme\Create\Handler $handler
    ): JsonResponse {
        $command->id = Id::next()->getValue();
        $handler->handle($command);

        return $this->json(
            [
                'id' => $command->id,
                'name' => $command->name,
                'code' => $command->code,
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/delete", methods={"POST"}, name=".delete")
     *
     * @OA\Post(
     *     summary="Удалить тему",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=204,
     *     description="Тема удалена"
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
     * @OA\Tag(name="Theme")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\Theme\Delete\Command $command
     * @param \App\Model\UseCase\Profile\Theme\Delete\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(
        Theme\Delete\Command $command,
        Theme\Delete\Handler $handler
    ): JsonResponse {
        $handler->handle($command);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/edit", methods={"POST"}, name=".edit")
     *
     * @OA\Post(
     *     summary="Изменить тему",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id", "name", "code"},
     *              @OA\Property(property="id", type="string", description="ID"),
     *              @OA\Property(property="name", type="string", description="Название"),
     *              @OA\Property(property="code", type="string", description="Код"),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Тема изменена",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID"),
     *         @OA\Property(property="name", type="string", description="Название"),
     *         @OA\Property(property="code", type="string", description="Код")
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
     * @OA\Tag(name="Theme")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\Theme\Edit\Command $command
     * @param \App\Model\UseCase\Profile\Theme\Edit\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function edit(
        Theme\Edit\Command $command,
        Theme\Edit\Handler $handler
    ): JsonResponse {
        $handler->handle($command);

        return $this->json(
            [
                'id' => $command->id,
                'name' => $command->name,
                'code' => $command->code,
            ],
            Response::HTTP_OK
        );
    }
}
