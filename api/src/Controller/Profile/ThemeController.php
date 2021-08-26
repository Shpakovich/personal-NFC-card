<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\UseCase\Profile\Theme;
use App\Security\Voter\Profile\ProfileAccess;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/theme", name="profile.theme")
 */
class ThemeController extends AbstractController
{
    /**
     * @Route("/change", methods={"POST"}, name=".change")
     *
     * @OA\Post(
     *     summary="Изменить тему профиля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"profile_id", "theme_id"},
     *              @OA\Property(property="profile_id", type="string", description="ID профиля"),
     *              @OA\Property(property="theme_id", type="string", description="ID темы")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Тема профиля изменена."
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
     * @param \App\Model\UseCase\Profile\Theme\Change\Command $command
     * @param \App\Model\UseCase\Profile\Theme\Change\Handler $handler
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function change(
        Theme\Change\Command $command,
        Theme\Change\Handler $handler,
        ProfileRepository $profiles
    ): JsonResponse {
        $profile = $profiles->getById(new Id($command->profileId));
        $this->denyAccessUnlessGranted(ProfileAccess::EDIT, $profile);

        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([]);
    }
}
