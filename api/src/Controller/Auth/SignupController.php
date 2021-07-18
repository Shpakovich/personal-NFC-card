<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Model\UseCase\User\Signup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/auth", name="auth")
 * @psalm-suppress PropertyNotSetInConstructor
 */
class SignupController extends AbstractController
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
     * @param \App\Model\UseCase\User\Signup\Request\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function request(Request $request, Signup\Request\Handler $handler): JsonResponse
    {
        /** @var string $content */
        $content = $request->getContent();
        /** @var \App\Model\UseCase\User\Signup\Request\Command $command */
        $command = $this->serializer->deserialize($content, Signup\Request\Command::class, 'json');

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 422, [], true);
        }

        $handler->handle($command);

        return $this->json([], 201);
    }

    /**
     * @Route("/confirm", name=".confirm", methods={"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\UseCase\User\Signup\Confirm\Handler $handler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function confirm(Request $request, Signup\Confirm\Handler $handler): JsonResponse
    {
        /** @var string $content */
        $content = $request->getContent();
        /** @var \App\Model\UseCase\User\Signup\Confirm\Command $command */
        $command = $this->serializer->deserialize($content, Signup\Confirm\Command::class, 'json');

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 422, [], true);
        }

        $handler->handle($command);

        return $this->json([]);
    }
}
