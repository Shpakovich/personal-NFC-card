<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Signup\Request;

use App\Model\UseCase\CommandInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     title="SignUpRequestCommand",
 *     description="Регистрация пользоателя",
 *     required={"email", "password"}
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

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     *
     * @OA\Property(property="password", type="string", description="Пароль")
     */
    public mixed $password = '';
}
