<?php

declare(strict_types=1);

namespace App\Controller\Field;

use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Field\TypeRepository;
use App\Model\UseCase\Field\Type;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/field", name="field")
 */
class TypeController extends AbstractController
{
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
            201
        );
    }
}
