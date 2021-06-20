<?php

declare(strict_types=1);

namespace App\Api\User\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class LessonUpdateRequestDto
{
    /**
     * @Assert\Length(max=30, min=3)
     */
    public ?string $title = null;

    public ?string $description = null;
}
