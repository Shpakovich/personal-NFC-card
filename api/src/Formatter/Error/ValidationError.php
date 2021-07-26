<?php

declare(strict_types=1);

namespace App\Formatter\Error;

use App\Exception\InvalidRequestData;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @OA\Schema(
 *     description="Ошибки валидации",
 *     @OA\Property(property="errors", type="array", description="Список ошибок",
 *         @OA\Items(
 *             @OA\Property(property="property", type="string", description="Название параметра"),
 *             @OA\Property(property="message", type="string", description="Описание ошибки"),
 *             @OA\Property(property="value", type="string", description="Описание ошибки"),
 *         )
 *     )
 * )
 */
class ValidationError
{
    private ConstraintViolationList $errors;

    public function __construct(InvalidRequestData $e)
    {
        $this->errors = $e->getViolations();
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->errors as $error) {
            $result[] = [
                'property' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
                'value' => $error->getInvalidValue(),
            ];
        }

        return [
            'errors' => $result,
        ];
    }
}
