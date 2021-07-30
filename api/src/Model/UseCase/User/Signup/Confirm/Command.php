<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Signup\Confirm;

use App\Model\UseCase\CommandInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     title="SignUpConfirmCommand",
 *     description="Подтверждение регистрации",
 *     required={"token"}
 * )
 */
class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @OA\Property(property="token", type="string", description="Токен на подтвержение регистрации")
     */
    public mixed $token = '';
}
