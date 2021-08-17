<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Exception\InvalidRequestData;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Service\Storage\Storage;
use App\Model\UseCase\Profile\Card;
use App\Model\UseCase\Profile\Photo;
use App\Security\Voter\Profile\ProfileAccess;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/profile/photo", name="profile.photo")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("/add", methods={"POST"}, name=".add")
     *
     * @OA\Post(
     *     summary="Добавить фотографию профиля",
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"file", "profile_id"},
     *                  @OA\Property(property="file", type="string", description="Файл", format="binary"),
     *                  @OA\Property(property="profile_id", type="string", description="ID профиля")
     *              )
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Фотография загружена и прикреплена к профилю."
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\Service\Storage\Storage $storage
     * @param \App\Model\UseCase\Profile\Photo\Add\Handler $handler
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Exception\InvalidRequestData
     */
    public function add(
        Request $request,
        Storage $storage,
        Photo\Add\Handler $handler,
        ProfileRepository $profiles,
        ValidatorInterface $validator
    ): JsonResponse {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $uploadedFile = $request->files->get('file');
        $profileId = $request->get('profile_id');

        if ($uploadedFile === null) {
            throw new \DomainException('The \'file\' field is empty.');
        }

        $command = new Photo\Add\Command();
        $command->userId = $user->getId();
        $command->profileId = $profileId;

        /** @var \Symfony\Component\Validator\ConstraintViolationList $errors */
        $errors = $validator->validate($command);
        if (\count($errors)) {
            throw new InvalidRequestData($errors);
        }

        $profile = $profiles->getById(new Id($profileId));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $profile);

        $file = $storage->upload($uploadedFile);

        $command->file = new Photo\Add\File(
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
     *     summary="Удалить фотографию профиля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"profile_id"},
     *              @OA\Property(property="profile_id", type="string", description="ID профиля"),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=204,
     *     description="Фото удалено."
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
     * @param \App\Model\UseCase\Profile\Photo\Remove\Command $command
     * @param \App\Model\UseCase\Profile\Photo\Remove\Handler $handler
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function remove(
        Photo\Remove\Command $command,
        Photo\Remove\Handler $handler,
        ProfileRepository $profiles
    ): JsonResponse {
        $profile = $profiles->getById(new Id($command->profileId));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $profile);

        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
