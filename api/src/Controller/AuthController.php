<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\UseCase\User\Signup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/auth", name="auth")
 */
class AuthController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/signup", name=".signup", methods={"POST"})
     *
     * @param \App\Model\UseCase\User\Signup\Request\Handler $handler
     */
    public function signup(Request $request, Signup\Request\Handler $handler): JsonResponse
    {
        /** @var string $content */
        $content = $request->getContent();
        /** @var \App\Model\UseCase\User\Signup\Request\Command $command */
        $command = $this->serializer->deserialize($content, Signup\Request\Command::class, 'json');

        $validations = $this->validator->validate($command);
        if (\count($validations)) {
            $json = $this->serializer->serialize($validations, 'json');
            return new JsonResponse($json, 422, [], true);
        }

        $handler->handle($command);

        return $this->json([], 201);
    }
}
