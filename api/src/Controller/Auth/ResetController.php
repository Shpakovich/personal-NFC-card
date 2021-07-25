<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Model\UseCase\User\Reset;
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
