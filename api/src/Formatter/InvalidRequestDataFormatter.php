<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Exception\InvalidRequestData;
use App\Formatter\Error\ValidationError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InvalidRequestDataFormatter implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof InvalidRequestData) {
            return;
        }

        $error = new ValidationError($exception);
        $event->setResponse(new JsonResponse($error->toArray(), 422));
    }
}
