<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\InvalidRequestData;
use App\Model\UseCase\CommandInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), CommandInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @var string $content */
        $content = $request->getContent();

        /** @var \App\Model\UseCase\User\Profile\Create\Command $command */
        $command = $this->serializer->deserialize(
            $content,
            $argument->getType(),
            JsonEncoder::FORMAT
        );

        $errors = $this->validator->validate($command);
        if (\count($errors)) {
            throw new InvalidRequestData($errors);
        }

        yield $command;
    }
}
