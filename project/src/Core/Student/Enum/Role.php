<?php

declare(strict_types=1);

namespace App\Core\Student\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Role extends AbstractEnum
{
    public const ADMIN = 'ROLE_ADMIN';
    public const MANAGER = 'ROLE_MANAGER';
    public const STUDENT  = 'ROLE_STUDENT';
    public const USER  = 'ROLE_USER';
}
