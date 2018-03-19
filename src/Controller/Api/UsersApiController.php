<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 17:43
 */

namespace App\Controller\Api;


use App\Domain\Model\CountryCode;
use App\Domain\Service\UserCreationService;
use App\Validator\Constraint\IdentityNumberConstraint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersApiController extends Controller
{
    /**
     * @var UserCreationService
     */
    private $creationService;

    public function __construct(UserCreationService $creationService)
    {
        $this->creationService = $creationService;
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

        $form = $this->createFormBuilder($formData)
            ->add('first_name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('surname', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('country_code', ChoiceType::class, [
                'required' => true,
                'choices' => CountryCode::getValues()
            ])
            ->add('identification_number', TextType::class, [
                'required' => true,
                'constraints' => [
                    new IdentityNumberConstraint(isset($formData['country_code']) ? $formData['country_code'] : null)
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        $form->submit($formData);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = $this->creationService->create(
                    $form->get('identification_number')->getData(),
                    CountryCode::get($form->get('country_code')->getData()),
                    $form->get('first_name')->getData(),
                    $form->get('surname')->getData()
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

    }
}