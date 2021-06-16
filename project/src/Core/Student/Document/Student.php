<?php

declare(strict_types=1);

namespace App\Core\Student\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\User\Repository\StudentRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=StudentRepository::class, collection="students")
 */
class Student extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $phone;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $surname;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $course;
    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $photo;
    /**
     * @MongoDB\Field(type="string")
     */
    protected string $city;

    protected User $user;

    public function __construct(
        string $phone, 
        string $name,
        string $surname,
        string $course,
        string $photo, 
        string $city,
        User $user
    ) {
        $this->phone = $phone;
        $this->name  = $name;
        $this->surname  = $surname;
        $this->course  = $course;
        $this->photo  = $photo;
        $this->city  = $city;
        $this->user  = $user;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getCourse(): string
    {
        return $this->course;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getCity(): string
    {
        return $this->city;
    }


    public function getUser(): User
    {
        return $this->user;
    }
}
