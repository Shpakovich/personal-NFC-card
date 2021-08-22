<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Controller\Guid;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Field as ProfileFieldEntity;
use App\Model\Repository\Profile\FieldRepository;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Service\Storage\Storage;
use App\Model\UseCase\Profile\Field;
use App\Security\Voter\Profile\ProfileAccess;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/field", name="profile.field")
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
     * @param \App\Model\UseCase\Profile\Field\Add\Command $command
     * @param \App\Model\UseCase\Profile\Field\Add\Handler $handler
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(
        Field\Add\Command $command,
        Field\Add\Handler $handler,
        ProfileRepository $profiles
    ): JsonResponse {
        $profile = $profiles->getById(new Id($command->profileId));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $profile);

        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->id = Id::next()->getValue();
        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json(
            [
                'id' => $command->id,
                'value' => $command->value,
            ],
            201
        );
    }

    /**
     * @Route("/delete", methods={"POST"}, name=".delete")
     *
     * @OA\Post(
     *     summary="Удалить поле профиля",
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
     * @param \App\Model\UseCase\Profile\Field\Delete\Command $command
     * @param \App\Model\UseCase\Profile\Field\Delete\Handler $handler
     * @param \App\Model\Repository\Profile\FieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(
        Field\Delete\Command $command,
        Field\Delete\Handler $handler,
        FieldRepository $fields
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
     *     summary="Изменить поле профиля",
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
     * @param \App\Model\UseCase\Profile\Field\Edit\Command $command
     * @param \App\Model\UseCase\Profile\Field\Edit\Handler $handler
     * @param \App\Model\Repository\Profile\FieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function edit(
        Field\Edit\Command $command,
        Field\Edit\Handler $handler,
        FieldRepository $fields
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
     *     summary="Изменить сортировку поля профиля",
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
     *     description="Сортировка поля изменена."
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
     * @param \App\Model\UseCase\Profile\Field\Sort\Command $command
     * @param \App\Model\UseCase\Profile\Field\Sort\Handler $handler
     * @param \App\Model\Repository\Profile\FieldRepository $fields
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sort(
        Field\Sort\Command $command,
        Field\Sort\Handler $handler,
        FieldRepository $fields
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
     * @Route("/{id}", methods={"GET"}, name=".show", requirements={
     *     "id"=Guid::PATTERN
     * })
     *
     * @OA\Get(
     *     summary="Получить поле профиля по его ID"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID поля профиля",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\Response(response=200, description="OK")
     * @OA\Response(response=404, description="Не найдена")
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\Entity\Profile\Field $profileField
     * @param \App\Model\Service\Storage\Storage $storage
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fieldsList(ProfileFieldEntity $profileField, Storage $storage): JsonResponse
    {
        $this->denyAccessUnlessGranted(ProfileAccess::VIEW, $profileField->getProfile());

        $field = $profileField->getField();
        $type = $profileField->getField()->getType();

        $icon = null;
        $path = $field->getIconPath();
        if ($path !== null) {
            $icon = [
                'path' => $storage->url($path)
            ];
        }

        return $this->json(
            [
                'id' => $profileField->getId()->getValue(),
                'title' => $field->getTitle(),
                'value' => $profileField->getValue(),
                'sort' => $profileField->getSort(),
                'field_id' => $field->getId()->getValue(),
                'type' => [
                    'id' => $type->getId()->getValue(),
                    'name' => $type->getName(),
                    'sort' => $type->getSort(),
                ],
                'icon' => $icon,
                'colors' => [
                    'bg' => $field->getBgColor()->getValue(),
                    'text' => $field->getTextColor()->getValue(),
                ]
            ]
        );
    }
}
