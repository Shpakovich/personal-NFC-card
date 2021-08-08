<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Formatter\Error;
use App\Model\UseCase\Profile\Card;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/card", name="profile.card")
 */
class CardController extends AbstractController
{
    /**
     * @Route("/attach", methods={"POST"}, name=".attach")
     *
     * @OA\Post(
     *     summary="Прикрепить карту к профилю",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"profile_id", "card_id"},
     *              @OA\Property(property="profile_id", type="string", description="ID профиля"),
     *              @OA\Property(property="card_id", type="string", description="ID карты")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Карта к профилю прикреплена."
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
     * @param \App\Model\UseCase\Profile\Card\Attach\Command $command
     * @param \App\Model\UseCase\Profile\Card\Attach\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function attach(Card\Attach\Command $command, Card\Attach\Handler $handler): JsonResponse
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([]);
    }

    /**
     * @Route("/detach", methods={"POST"}, name=".detach")
     *
     * @OA\Post(
     *     summary="Открепить карту от профиля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"profile_id"},
     *              @OA\Property(property="profile_id", type="string", description="ID профиля"),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Карта откреплена от профиля."
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
     * @param \App\Model\UseCase\Profile\Card\Detach\Command $command
     * @param \App\Model\UseCase\Profile\Card\Detach\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function detach(Card\Detach\Command $command, Card\Detach\Handler $handler): JsonResponse
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->userId = $user->getId();
        $handler->handle($command);

        return $this->json([]);
    }
}
