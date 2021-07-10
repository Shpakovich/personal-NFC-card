<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Model\UseCase\User\Reset;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/auth/reset", name="auth.reset")
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ResetController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/request", name=".request", methods={"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\UseCase\User\Reset\Request\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function request(Request $request, Reset\Request\Handler $handler): JsonResponse
    {
        /** @var string $content */
        $content = $request->getContent();
        /** @var \App\Model\UseCase\User\Reset\Request\Command $command */
        $command = $this->serializer->deserialize($content, Reset\Request\Command::class, 'json');

        $validations = $this->validator->validate($command);
        if (\count($validations)) {
            $json = $this->serializer->serialize($validations, 'json');
            return new JsonResponse($json, 422, [], true);
        }

        $handler->handle($command);

        return $this->json([], 201);
    }

    /**
     * @Route("/confirm", name=".confirm", methods={"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\UseCase\User\Reset\Confirm\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function confirm(Request $request, Reset\Confirm\Handler $handler): JsonResponse
    {
        /** @var string $content */
        $content = $request->getContent();
        /** @var \App\Model\UseCase\User\Reset\Confirm\Command $command */
        $command = $this->serializer->deserialize($content, Reset\Confirm\Command::class, 'json');

        $validations = $this->validator->validate($command);
        if (\count($validations)) {
            $json = $this->serializer->serialize($validations, 'json');
            return new JsonResponse($json, 422, [], true);
        }

        $handler->handle($command);

        return $this->json([]);
    }
}
