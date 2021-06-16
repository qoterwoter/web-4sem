<?php

declare(strict_types=1);

namespace App\Core\Student\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Permission extends AbstractEnum
{
    public const STUDENT_CONTACT_CREATE = 'ROLE_STUDENT_CONTACT_CREATE';
    public const STUDENT_SHOW           = 'ROLE_STUDENT_SHOW';
    public const STUDENT_INDEX          = 'ROLE_STUDENT_INDEX';
    public const STUDENT_CREATE         = 'ROLE_STUDENT_CREATE';
    public const STUDENT_UPDATE         = 'ROLE_STUDENT_UPDATE';
    public const STUDENT_DELETE         = 'ROLE_STUDENT_DELETE';
    public const STUDENT_VALIDATION     = 'ROLE_STUDENT_VALIDATION';
}
