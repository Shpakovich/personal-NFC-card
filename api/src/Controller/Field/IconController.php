<?php

declare(strict_types=1);

namespace App\Controller\Field;

use App\Exception\InvalidRequestData;
use App\Formatter\Error;
use App\Model\Service\Storage\Storage;
use App\Model\UseCase\Field\Field\Icon;
use App\Model\UseCase\Profile\Card;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/field/icon", name="field.icon")
 */
class IconController extends AbstractController
{
    /**
     * @Route("/add", methods={"POST"}, name=".add")
     *
     * @OA\Post(
     *     summary="Добавить иконку у поля",
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"file", "field_id"},
     *                  @OA\Property(property="file", type="string", description="Файл", format="binary"),
     *                  @OA\Property(property="field_id", type="string", description="ID поля")
     *              )
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Иконка загружена и прикреплена к полю."
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\Service\Storage\Storage $storage
     * @param \App\Model\UseCase\Field\Field\Icon\Add\Handler $handler
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Exception\InvalidRequestData
     */
    public function add(
        Request $request,
        Storage $storage,
        Icon\Add\Handler $handler,
        ValidatorInterface $validator
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        /** @var null|\Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');
        if ($uploadedFile === null) {
            throw new \DomainException('The \'file\' field is empty.');
        }

        $command = new Icon\Add\Command();
        $command->userId = $user->getId();
        /** @var string fieldId */
        $command->fieldId = $request->get('field_id');

        /** @var \Symfony\Component\Validator\ConstraintViolationList $errors */
        $errors = $validator->validate($command);
        if (\count($errors)) {
            throw new InvalidRequestData($errors);
        }

        $file = $storage->upload($uploadedFile);

        $command->icon = new Icon\Add\Icon(
            $file->getPath(),
            $file->getName()
        );

        $handler->handle($command);

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @Route("/remove", methods={"POST"}, name=".remove")
     *
     * @OA\Post(
     *     summary="Удалить иконку у поля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"field_id"},
     *              @OA\Property(property="field_id", type="string", description="ID поля"),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=204,
     *     description="Иконка удалена."
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
     * @param \App\Model\UseCase\Field\Field\Icon\Remove\Command $command
     * @param \App\Model\UseCase\Field\Field\Icon\Remove\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function remove(
        Icon\Remove\Command $command,
        Icon\Remove\Handler $handler
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
