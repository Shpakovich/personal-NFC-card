<?php

declare(strict_types=1);

namespace App\Formatter;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class NotNormalizableValueExceptionFormatter implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $error = $event->getThrowable();

        if (!$error instanceof NotNormalizableValueException) {
            return;
        }

        $event->setResponse(
            new JsonResponse([
                'error' => [
                    'code' => 400,
                    'message' => 'Not supported format request.',
                ]
            ], 400)
        );
    }
}
