<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 17:43
 */

namespace App\Controller\Api;


use App\Domain\Model\CountryCode;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Service\UserCreationService;
use App\Form\User\UserDto;
use App\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersApiController extends Controller
{
    /**
     * @var UserCreationService
     */
    private $creationService;
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserCreationService $creationService,
                                UserRepository $repository)
    {
        $this->creationService = $creationService;
        $this->repository = $repository;
    }

    public function createAction(Request $request)
    {
        $formData = json_decode($request->getContent(), true);
        if (!$formData) {
            $error = [
                'code' => 400,
                'message' => 'Bad Request: only JSON content type allowed'
            ];
            return new Response(json_encode($error), 400, ['Content-Type' => 'application/json']);
        }

        $userDto = new UserDto();

        $form = $this->createForm(UserType::class, $userDto, [
            'country_code' => isset($formData['country_code']) ? $formData['country_code'] : null
        ]);

        $form->handleRequest($request);
        $form->submit($formData);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = $this->creationService->create(
                    $userDto->getIdentificationNumber(),
                    CountryCode::get($userDto->getCountryCode()),
                    $userDto->getFirstName(),
                    $userDto->getSurname()
                );

                return new Response(json_encode($user), 201, ['Content-Type' => 'application/json']);
            }

            $error = [
                'code' => 422,
                'message' => 'Validation Failed',
                'errors' => []
            ];


            foreach ($form->getErrors(true) as $formError) {
                $error['errors'][$formError->getOrigin()->getName()] = $formError->getMessage();
            }

            return new Response(json_encode($error), 422, ['Content-Type' => 'application/json']);
        }
    }

    public function listAction()
    {
        $users = $this->repository->fetchAll();

        return new Response(
            json_encode(
                array_map(function (User $user) {
                    return $user->jsonSerialize();
                }, $users)
            )
        );
    }
}