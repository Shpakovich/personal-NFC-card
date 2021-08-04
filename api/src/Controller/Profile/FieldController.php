<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\UseCase\User\Profile\Field;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/field", name="profile")
 */
class FieldController extends AbstractController
{
    /**
     * @Route("/add", methods={"POST"}, name=".add")
     *
     * @OA\Post(
     *     summary="Добавить поле в профиль",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="profile_id", type="string", description="ID профиля"),
     *              @OA\Property(property="field_id", type="string", description="ID поля"),
     *              @OA\Property(property="value", type="string", description="Значение поля"),
     *              @OA\Property(property="sort", type="integer", description="Порядок вывода")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Поле добавлено.",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string"),
     *         @OA\Property(property="value", type="string"),
     *         @OA\Property(property="sort", type="integer")
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
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\User\Profile\Field\Add\Command $command
     * @param \App\Model\UseCase\User\Profile\Field\Add\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(Field\Add\Command $command, Field\Add\Handler $handler): JsonResponse
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->id = Id::next()->getValue();
        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json(
            [
                'id' => $command->id,
                'value' => $command->value,
                'sort' => $command->sort,
            ],
            201
        );
    }
}
