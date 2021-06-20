<?php

declare(strict_types=1);

namespace App\Core\Lesson\Factory;

use App\Core\Lesson\Document\Lesson;

class LessonFactory
{
    public function create(
        string $title,
        string $description,
        string $teacher
    ): Lesson {
        $lesson = new Lesson(
            $title,
            $description,
            $teacher
        );

        return $lesson;
    }
}
