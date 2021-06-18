<?php

declare(strict_types=1);

namespace App\Api\User\Dto;

class LessonResponseDto
{
    public ?string $id = null;

    public string $title;

    public string $description;

    public string $teacher;
}
