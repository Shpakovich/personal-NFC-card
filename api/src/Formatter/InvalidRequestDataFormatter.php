<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Exception\InvalidRequestData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class InvalidRequestDataFormatter implements EventSubscriberInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $error = $event->getThrowable();

        if (!$error instanceof InvalidRequestData) {
            return;
        }

        $event->setResponse(
            new JsonResponse(
                $this->serializer->serialize($error->getErrors(), JsonEncoder::FORMAT),
                422,
                [],
                true
            )
        );
    }
}
