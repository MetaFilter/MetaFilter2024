<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionEnum: string
{
    case AccessAdminPanel = 'access-admin-panel';

    public function label(): string
    {
        return match ($this) {
            self::AccessAdminPanel => 'Access Admin Panel',
        };
    }
}
