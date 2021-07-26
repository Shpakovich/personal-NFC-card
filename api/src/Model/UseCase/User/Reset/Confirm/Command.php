<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Reset\Confirm;

use App\Model\UseCase\CommandInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     title="ResetConfirmCommand",
 *     description="Запрос на сброс пароля",
 *     required={"token", "password"}
 * )
 */
class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @OA\Property(property="token", type="string", description="Токен на сброс пароля")
     */
    public mixed $token = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     *
     * @OA\Property(property="password", type="string", description="Новый пароль")
     */
    public mixed $password = '';
}
