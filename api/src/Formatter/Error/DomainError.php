<?php

declare(strict_types=1);

namespace App\Formatter\Error;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="error", type="object",
 *         @OA\Property(property="code", type="integer"),
 *         @OA\Property(property="message", type="string"),
 *     )
 * )
 */
class DomainError
{
    private int $code;
    private string $message;

    public function __construct(\DomainException $e)
    {
        $code = $e->getCode();
        if (!$this->isCodeValid($code)) {
            $code = 400;
        }

        $this->code = $code;
        $this->message = $e->getMessage();
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function toArray(): array
    {
        return [
            'error' => [
                'code' => $this->code,
                'message' => $this->message,
            ]
        ];
    }

    private function isCodeValid(int|string $code): bool
    {
        return is_int($code) && $code > 399 && $code < 500;
    }
}
