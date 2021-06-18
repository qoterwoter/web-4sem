<?php

declare(strict_types=1);

namespace App\Core\User\Repository;


use App\Core\Common\Repository\AbstractRepository;
use App\Core\User\Document\Lesson;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Lesson save(Lesson $user)
 * @method Lesson|null find(string $id)
 * @method Lesson|null findOneBy(array $criteria)
 * @method Lesson getOne(string $id)
 */
class LessonRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Lesson::class;
    }

    /**
     * @throws LockException
     * @throws MappingException|MappingException
     */
    public function getLessonById(string $id): ?Lesson
    {
        return $this->find($id);
    }
}
