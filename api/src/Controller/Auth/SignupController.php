<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Formatter\Error\DomainError;
use App\Model\UseCase\User\Signup;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth", name="auth")
 * @psalm-suppress PropertyNotSetInConstructor
 */
class SignupController extends AbstractController
{
    /**
     * @Route("/request", name=".request", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Запрос на регистрацию нового пользователя.",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", description="Email пользователя"),
     *              @OA\Property(property="password", type="string", description="Пароль")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Запрос на регистрацию выполнен успешно."
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="Ошибки бизнес логики, например, такой пользователь уже существует.",
     *     @OA\JsonContent(ref=@Model(type=DomainError::class))
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="Ошибка валидации входных данных.",
     *     @OA\JsonContent(
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="detail", type="string"),
     *          @OA\Property(property="violations", type="array", description="Ошибки валидации",
     *              @OA\Items(
     *                  @OA\Property(property="propertyPath", type="string", description="Название параметра"),
     *                  @OA\Property(property="title", type="string", description="Описание ошибки"),
     *              )
     *          ),
     *     )
     * )
     *
     * @OA\Tag(name="Auth")
     * @OA\Tag(name="Sign Up")
     *
     * @param \App\Model\UseCase\User\Signup\Request\Command $command
     * @param \App\Model\UseCase\User\Signup\Request\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function request(Signup\Request\Command $command, Signup\Request\Handler $handler): JsonResponse
    {
        $handler->handle($command);
        return $this->json([], 201);
    }

    /**
     * @Route("/confirm", name=".confirm", methods={"POST"})
     *
     * @param \App\Model\UseCase\User\Signup\Confirm\Command $command
     * @param \App\Model\UseCase\User\Signup\Confirm\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function confirm(Signup\Confirm\Command $command, Signup\Confirm\Handler $handler): JsonResponse
    {
        $handler->handle($command);
        return $this->json([]);
    }
}
