<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\User\Token;
use Ramsey\Uuid\Uuid;

class Tokenizer
{
    public function generate(\DateTimeImmutable $data): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $data->modify('+1 hour')
        );
    }
}
