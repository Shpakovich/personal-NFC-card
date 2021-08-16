<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Create;

use App\Model\UseCase\CommandInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     title="UserCreateCommand",
 *     description="Создание пользователя",
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

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @Assert\Type(type="string")
     * @Assert\Choice({"ROLE_ADMIN", "ROLE_USER"}, message="Right values: ROLE_ADMIN, ROLE_USER")
     *
     * @OA\Property(property="role", type="string", description="Роль")
     */
    public mixed $role = '';

    /**
     * @var int
     * @Assert\NotBlank()
     *
     * @Assert\Type(type="int")
     * @Assert\Choice({0, 1}, message="Right values: 0 - WAIT, 1 - ACTIVE")
     *
     * @OA\Property(property="status", type="integer", description="Статус")
     */
    public mixed $status = 0;
}
