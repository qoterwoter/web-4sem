<?php

declare(strict_types=1);

namespace App\Core\Lesson\Enum;

use App\Core\Common\Enum\AbstractEnum;

final class RoleHumanReadable extends AbstractEnum
{
    public const ADMIN = 'Администратор';
    public const USER  = 'Пользователь';
    public const LESSON_MANAGER  = 'Менеджер предметов';
    public const MODERATOR  = 'Модератор';
}
