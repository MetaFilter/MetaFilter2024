<?php

declare(strict_types=1);

namespace App\Traits;

trait EmailAddressTrait
{
    public function isValidEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
