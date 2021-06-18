<?php

declare(strict_types=1);

namespace App\Core\User\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\User\Repository\LessonRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=LessonRepository::class, collection="lessons")
 */
class Lesson extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\UniqueIndex(name="lesson_title")
     */
    protected string $title;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $description;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $teacher;

    /**
     * @ReferenceOne(targetDocument=User::class)
     */
    protected User $user;

    public function __construct(string $title, string $description, string $teacher, User $user)
    {
        $this->title = $title;
        $this->description  = $description;
        $this->user  = $user;
        $this->teacher  = $teacher;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTeacher(): string
    {
        return $this->teacher;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
