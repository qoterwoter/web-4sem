<?php

declare(strict_types=1);

namespace App\Core\Lesson\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Permission extends AbstractEnum
{
    public const LESSON_SHOW           = 'ROLE_LESSON_SHOW';
    public const LESSON_INDEX          = 'ROLE_LESSON_INDEX';
    public const LESSON_CREATE         = 'ROLE_LESSON_CREATE';
    public const LESSON_UPDATE         = 'ROLE_LESSON_UPDATE';
    public const LESSON_DELETE         = 'ROLE_LESSON_DELETE';
    public const LESSON_VALIDATION     = 'ROLE_LESSON_VALIDATION';
}
