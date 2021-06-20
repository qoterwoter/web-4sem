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

    public function __construct(string $title, string $description, string $teacher)
    {
        $this->title = $title;
        $this->description  = $description;
        $this->teacher  = $teacher;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTeacher(): string
    {
        return $this->teacher;
    }
    public function setTeacher(?string $teacher): void
    {
        $this->teacher = $teacher;
    }
}
