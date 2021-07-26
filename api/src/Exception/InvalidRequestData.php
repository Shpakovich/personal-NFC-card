<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class InvalidRequestData extends \Exception
{
    private ConstraintViolationList $violations;

    public function __construct(ConstraintViolationList $violations)
    {
        parent::__construct();

        $this->violations = $violations;
    }

    public function getViolations(): ConstraintViolationList
    {
        return $this->violations;
    }
}
