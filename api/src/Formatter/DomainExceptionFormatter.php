<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Formatter\Error\DomainError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DomainExceptionFormatter implements EventSubscriberInterface
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
        if (!$exception instanceof \DomainException) {
            return;
        }

        $error = new DomainError($exception);
        $event->setResponse(new JsonResponse($error->toArray(), $error->getCode()));
    }
}
