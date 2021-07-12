<?php

declare(strict_types=1);

namespace App\Controller;

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
        $error = $event->getThrowable();

        if (!$error instanceof \DomainException) {
            return;
        }

        $code = $error->getCode();
        if (!$this->isCodeValid($code)) {
            $code = 400;
        }

        $event->setResponse(
            new JsonResponse([
                'error' => [
                    'code' => $code,
                    'message' => $error->getMessage(),
                ]
            ], (int)$code)
        );
    }

    public function isCodeValid(int|string $code): bool
    {
        return is_int($code) && $code > 399 && $code < 500;
    }
}
