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
        $type = $argument->getType();
        if ($type === null) {
            return false;
        }

        return is_subclass_of($type, CommandInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();
        if ($type === null) {
            throw new \RuntimeException('Could not resolve command.');
        }

        /** @var string $content */
        $content = $request->getContent();

        /** @var \App\Model\UseCase\User\Profile\Create\Command $command */
        $command = $this->serializer->deserialize(
            $content,
            $type,
            JsonEncoder::FORMAT
        );

        /** @var \Symfony\Component\Validator\ConstraintViolationList $errors */
        $errors = $this->validator->validate($command);
        if (\count($errors)) {
            throw new InvalidRequestData($errors);
        }

        yield $command;
    }
}
