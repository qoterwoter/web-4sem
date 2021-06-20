<?php

declare(strict_types=1);

namespace App\Api\Lesson\Dto;

class LessonListResponseDto
{
    public array $lessons;

    public function __construct(LessonResponseDto ... $lessons)
    {
        $this->lessons = $lessons;
    }
}
