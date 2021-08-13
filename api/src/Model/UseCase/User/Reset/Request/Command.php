<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Reset\Request;

use App\Model\UseCase\CommandInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     title="ResetRequestCommand",
 *     description="Запрос на сброс пароля",
 *     required={"email"}
 * )
 */
class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     * @Assert\Email(mode="html5")
     *
     * @OA\Property(property="email", type="string", description="Email пользователя")
     */
    public mixed $email = '';
}
