<?php

declare(strict_types=1);

namespace App\Api\User\Controller;

use App\Api\User\Dto\ContactResponseDto;
use App\Api\User\Dto\LessonCreateRequestDto;
use App\Api\User\Dto\LessonListResponseDto;
use App\Api\User\Dto\LessonResponseDto;
use App\Api\User\Dto\LessonUpdateRequestDto;
use App\Api\User\Dto\ValidationExampleRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\User\Document\Contact;
use App\Core\User\Document\Lesson;
use App\Core\User\Enum\Permission;
use App\Core\User\Enum\Role;
use App\Core\User\Enum\RoleHumanReadable;
use App\Core\User\Repository\ContactRepository;
use App\Core\User\Repository\LessonRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/lessons")
 */
class LessonController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(Permission::LESSON_SHOW)
     *
     * @ParamConverter("lesson")
     *
     * @Rest\View()
     *
     * @param Lesson|null $lesson
     *
     * @return LessonResponseDto
     */
    public function show(Lesson $lesson = null, ContactRepository $contactRepository)
    {
        if (!$lesson) {
            throw $this->createNotFoundException('Lesson not found');
        }

        $contact = $contactRepository->findOneBy(['lesson' => $lesson]);

        return $this->createLessonResponse($lesson, $contact);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::LESSON_INDEX)
     * @Rest\View()
     *
     * @return LessonListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        LessonRepository $lessonRepository
    ): LessonListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $lessons = $lessonRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new LessonListResponseDto(
            ... array_map(
                    function (Lesson $lesson) {
                        return $this->createLessonResponse($lesson);
                    },
                    $lessons
                )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(Permission::LESSON_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param LessonCreateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param LessonRepository                   $lessonRepository
     *
     * @return LessonResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        LessonCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        LessonRepository $lessonRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        if ($lesson = $lessonRepository->findOneBy(['title' => $requestDto->title])) {
            return new Response('Lesson already exists', Response::HTTP_BAD_REQUEST);
        }

        $lesson = new Lesson(
            $requestDto->title,
            $requestDto->description,
            $requestDto->teacher
        );
        $lesson->setTitle($requestDto->title);
        $lesson->setDescription($requestDto->description);

        $lessonRepository->save($lesson);

        return $this->createLessonResponse($lesson);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}/contact", methods={"POST"})
     * @IsGranted(Permission::LESSON_STUDENT_CREATE)
     * @ParamConverter("lesson")
     *
     * @Rest\View(statusCode=201)
     *
     * @param Request           $request
     * @param Lesson|null         $lesson
     * @param ContactRepository $contactRepository
     *
     * @return LessonResponseDto|ValidationFailedResponse|Response
     */
    public function createContact(
        Request $request,
        Lesson $lesson = null,
        ContactRepository $contactRepository
    ) {
        // todo проверки на валидацию всего всего и дто ...
        $contact = new Contact($request->get('title', ''), $request->get('description', ''), $lesson);
        $contactRepository->save($contact);

        return $this->createLessonResponse($lesson, $contact);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::LESSON_UPDATE)
     * @ParamConverter("lesson")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param LessonUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param LessonRepository                   $lessonRepository
     *
     * @return LessonResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Lesson $lesson = null,
        LessonUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        LessonRepository $lessonRepository
    ) {
        if (!$lesson) {
            throw $this->createNotFoundException('Lesson not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $lesson->setTitle($requestDto->title);
        $lesson->setDescription($requestDto->description);

        $lessonRepository->save($lesson);

        return $this->createLessonResponse($lesson);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(Permission::LESSON_DELETE)
     * @ParamConverter("lesson")
     *
     * @Rest\View()
     *
     * @param Lesson|null      $lesson
     * @param LessonRepository $lessonRepository
     *
     * @return LessonResponseDto|ValidationFailedResponse
     */
    public function delete(
        LessonRepository $lessonRepository,
        Lesson $lesson = null
    ) {
        if (!$lesson) {
            throw $this->createNotFoundException('Lesson not found');
        }

        $lessonRepository->remove($lesson);
    }

    private function getRoleHumanReadable(Lesson $lesson): ?string
    {
        if (in_array(Role::ADMIN, $lesson->getRoles(), true)) {
            return RoleHumanReadable::ADMIN;
        }

        if (in_array(Role::LESSON, $lesson->getRoles(), true)) {
            return RoleHumanReadable::LESSON;
        }

        return null;
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(Permission::LESSON_VALIDATION)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @return ValidationExampleRequestDto|ValidationFailedResponse
     */
    public function validation(
        ValidationExampleRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $requestDto;
    }

    /**
     * @param Lesson         $lesson
     * @param Contact|null $contact
     *
     * @return LessonResponseDto
     */
    private function createLessonResponse(Lesson $lesson, ?Contact $contact = null): LessonResponseDto
    {
        $dto = new LessonResponseDto();

        $dto->id                = $lesson->getId();
        $dto->title         = $lesson->getTitle();
        $dto->description          = $lesson->getDescription();
        $dto->teacher             = $lesson->getTeacher();

        return $dto;
    }
}
