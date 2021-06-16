<?php

declare(strict_types=1);

namespace App\Api\Student\Controller;

use App\Api\Student\Dto\ContactResponseDto;
use App\Api\Student\Dto\StudentCreateRequestDto;
use App\Api\Student\Dto\StudentListResponseDto;
use App\Api\Student\Dto\StudentResponseDto;
use App\Api\Student\Dto\StudentUpdateRequestDto;
use App\Api\Student\Dto\ValidationExampleRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Student\Document\Contact;
use App\Core\Student\Document\Student;
use App\Core\Student\Enum\Permission;
use App\Core\Student\Enum\Role;
use App\Core\Student\Enum\RoleHumanReadable;
use App\Core\Student\Repository\ContactRepository;
use App\Core\Student\Repository\StudentRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/students")
 */
class StudentController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(Permission::USER_SHOW)
     *
     * @ParamConverter("student")
     *
     * @Rest\View()
     *
     * @param Student|null $student
     *
     * @return StudentResponseDto
     */
    public function show(Student $student = null, ContactRepository $contactRepository)
    {
        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        $contact = $contactRepository->findOneBy(['student' => $student]);

        return $this->createStudentResponse($student, $contact);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::USER_INDEX)
     * @Rest\View()
     *
     * @return StudentListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        StudentRepository $studentRepository
    ): StudentListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $students = $studentRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new StudentListResponseDto(
            ... array_map(
                    function (Student $student) {
                        return $this->createStudentResponse($student);
                    },
                    $students
                )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(Permission::USER_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param StudentCreateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param StudentRepository                   $studentRepository
     *
     * @return StudentResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        StudentCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        StudentRepository $studentRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        if ($student = $studentRepository->findOneBy(['phone' => $requestDto->phone])) {
            return new Response('Student already exists', Response::HTTP_BAD_REQUEST);
        }

        $student = new Student(
            $requestDto->phone,
            $requestDto->roles,
            $requestDto->apiToken
        );
        $student->setFirstName($requestDto->firstName);
        $student->setLastName($requestDto->lastName);

        $studentRepository->save($student);

        return $this->createStudentResponse($student);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}/contact", methods={"POST"})
     * @IsGranted(Permission::USER_CONTACT_CREATE)
     * @ParamConverter("student")
     *
     * @Rest\View(statusCode=201)
     *
     * @param Request           $request
     * @param Student|null         $student
     * @param ContactRepository $contactRepository
     *
     * @return StudentResponseDto|ValidationFailedResponse|Response
     */
    public function createContact(
        Request $request,
        Student $student = null,
        ContactRepository $contactRepository
    ) {
        // todo проверки на валидацию всего всего и дто ...
        $contact = new Contact($request->get('phone', ''), $request->get('name', ''), $student);
        $contactRepository->save($contact);

        return $this->createStudentResponse($student, $contact);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::USER_UPDATE)
     * @ParamConverter("student")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param StudentUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param StudentRepository                   $studentRepository
     *
     * @return StudentResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Student $student = null,
        StudentUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        StudentRepository $studentRepository
    ) {
        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $student->setFirstName($requestDto->firstName);
        $student->setLastName($requestDto->lastName);

        $studentRepository->save($student);

        return $this->createStudentResponse($student);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(Permission::USER_DELETE)
     * @ParamConverter("student")
     *
     * @Rest\View()
     *
     * @param Student|null      $student
     * @param StudentRepository $studentRepository
     *
     * @return StudentResponseDto|ValidationFailedResponse
     */
    public function delete(
        StudentRepository $studentRepository,
        Student $student = null
    ) {
        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        $studentRepository->remove($student);
    }

    private function getRoleHumanReadable(Student $student): ?string
    {
        if (in_array(Role::ADMIN, $student->getRoles(), true)) {
            return RoleHumanReadable::ADMIN;
        }

        if (in_array(Role::USER, $student->getRoles(), true)) {
            return RoleHumanReadable::USER;
        }

        return null;
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(Permission::USER_VALIDATION)
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
     * @param Student         $student
     * @param Contact|null $contact
     *
     * @return StudentResponseDto
     */
    private function createStudentResponse(Student $student, ?Contact $contact = null): StudentResponseDto
    {
        $dto = new StudentResponseDto();

        $dto->id                = $student->getId();
        $dto->name         = $student->getFirstName();
        $dto->surname          = $student->getSurname();
        $dto->phone             = $student->getPhone();
        $dto->course          = $student->getCourse();
        $dto->photo             = $student->getPhoto();
        $dto->city             = $student->getCity();
        $dto->roleHumanReadable = $this->getRoleHumanReadable($student);
        $dto->token             = $student->getApiToken();

        if ($contact) {
            $contactResponseDto        = new ContactResponseDto();
            $contactResponseDto->id    = $contact->getId();
            $contactResponseDto->phone = $contact->getPhone();
            $contactResponseDto->name  = $contact->getName();

            $dto->contact = $contactResponseDto;
        }

        return $dto;
    }
}
