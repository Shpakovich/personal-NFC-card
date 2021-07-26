<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Formatter\Error;
use App\Model\UseCase\User\Reset;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/reset", name="auth.reset")
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ResetController extends AbstractController
{
    /**
     * @Route("/request", name=".request", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Запрос на сброс пароля.",
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref=@Model(type=Reset\Request\Command::class))
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Запрос на сброс пароля выполнен успешно."
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
     * @OA\Tag(name="Auth")
     *
     * @param \App\Model\UseCase\User\Reset\Request\Command $command
     * @param \App\Model\UseCase\User\Reset\Request\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function request(Reset\Request\Command $command, Reset\Request\Handler $handler): JsonResponse
    {
        $handler->handle($command);
        return $this->json([], 201);
    }

    /**
     * @Route("/confirm", name=".confirm", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Выполинть сброс пароля.",
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref=@Model(type=Reset\Confirm\Command::class))
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Пароль изменен успешно."
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="Ошибки бизнес логики, например, неверный токен.",
     *     @OA\JsonContent(ref=@Model(type=Error\DomainError::class))
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="Ошибка валидации входных данных.",
     *     @OA\JsonContent(ref=@Model(type=Error\ValidationError::class))
     * )
     *
     * @OA\Tag(name="Auth")
     *
     * @param \App\Model\UseCase\User\Reset\Confirm\Command $command
     * @param \App\Model\UseCase\User\Reset\Confirm\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function confirm(Reset\Confirm\Command $command, Reset\Confirm\Handler $handler): JsonResponse
    {
        $handler->handle($command);
        return $this->json([]);
    }
}
