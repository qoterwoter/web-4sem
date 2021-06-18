<?php

declare(strict_types=1);

namespace App\Api\User\Dto;

class UserListResponseDto
{
    public array $students;

    public function __construct(UserResponseDto ... $students)
    {
        $this->students = $students;
    }
}
