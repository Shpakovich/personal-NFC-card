<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Field\CustomFieldRepository;
use App\Model\Repository\Profile\CustomFieldRepository as ProfileCustomFieldRepository;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\UseCase\Profile\FieldCustom;
use App\Security\Voter\Field\CustomFieldAccess;
use App\Security\Voter\Profile\ProfileAccess;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/field/custom", name="profile.field.custom")
 */
class FieldCustomController extends AbstractController
{
    /**
     * @Route("/add", methods={"POST"}, name=".add")
     *
     * @OA\Post(
     *     summary="Добавить пользовательское поле в профиль",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"profile_id", "field_id", "value"},
     *              @OA\Property(property="profile_id", type="string", description="ID профиля"),
     *              @OA\Property(property="field_id", type="string", description="ID поля"),
     *              @OA\Property(property="value", type="string", description="Значение поля")
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
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\FieldCustom\Add\Command $command
     * @param \App\Model\UseCase\Profile\FieldCustom\Add\Handler $handler
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @param \App\Model\Repository\Field\CustomFieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(
        FieldCustom\Add\Command $command,
        FieldCustom\Add\Handler $handler,
        ProfileRepository $profiles,
        CustomFieldRepository $fields
    ): JsonResponse {
        $profile = $profiles->getById(new Id($command->profileId));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $profile);

        $field = $fields->getById(new Id($command->fieldId));
        $this->denyAccessUnlessGranted(CustomFieldAccess::EDIT, $field);

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

    /**
     * @Route("/delete", methods={"POST"}, name=".delete")
     *
     * @OA\Post(
     *     summary="Удалить пользовательское поле профиля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id"},
     *              @OA\Property(property="id", type="string", description="ID поля"),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=204,
     *     description="Поле удалено."
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
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\FieldCustom\Delete\Command $command
     * @param \App\Model\UseCase\Profile\FieldCustom\Delete\Handler $handler
     * @param \App\Model\Repository\Profile\CustomFieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(
        FieldCustom\Delete\Command $command,
        FieldCustom\Delete\Handler $handler,
        ProfileCustomFieldRepository $fields
    ): JsonResponse {
        $field = $fields->getById(new Id($command->id));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $field->getProfile());

        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([], 204);
    }

    /**
     * @Route("/edit", methods={"POST"}, name=".edit")
     *
     * @OA\Post(
     *     summary="Изменить пользовательское поле профиля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id", "value"},
     *              @OA\Property(property="id", type="string", description="ID поля профиля"),
     *              @OA\Property(property="field_id", type="string", description="ID поля"),
     *              @OA\Property(property="value", type="string", description="Значение поля")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Поле изменено."
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
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\FieldCustom\Edit\Command $command
     * @param \App\Model\UseCase\Profile\FieldCustom\Edit\Handler $handler
     * @param \App\Model\Repository\Profile\CustomFieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function edit(
        FieldCustom\Edit\Command $command,
        FieldCustom\Edit\Handler $handler,
        ProfileCustomFieldRepository $fields
    ): JsonResponse {
        $field = $fields->getById(new Id($command->id));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $field->getProfile());

        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([]);
    }

    /**
     * @Route("/sort", methods={"POST"}, name=".sort")
     *
     * @OA\Post(
     *     summary="Изменить сортировку пользовательского поля профиля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id", "sort"},
     *              @OA\Property(property="id", type="string", description="ID поля профиля"),
     *              @OA\Property(property="sort", type="integer", description="Порядок вывода")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Поле изменено."
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
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\Profile\FieldCustom\Sort\Command $command
     * @param \App\Model\UseCase\Profile\FieldCustom\Sort\Handler $handler
     * @param \App\Model\Repository\Profile\CustomFieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sort(
        FieldCustom\Sort\Command $command,
        FieldCustom\Sort\Handler $handler,
        ProfileCustomFieldRepository $fields
    ): JsonResponse {
        $field = $fields->getById(new Id($command->id));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $field->getProfile());

        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([]);
    }
}
