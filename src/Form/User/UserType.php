<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 20/03/2018
 * Time: 17:31
 */

namespace App\Form\User;


use App\Domain\Model\CountryCode;
use App\Validator\Constraint\IdentityNumberConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $countryCode = $options['country_code'];

        $builder
            ->add('first_name', TextType::class, [
                'required' => true,
                'property_path' => 'firstName',
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
                'property_path' => 'countryCode',
                'invalid_message' => 'Only PL and DE registrations are allowed',
                'choices' => CountryCode::getValues()
            ])
            ->add('identification_number', TextType::class, [
                'required' => true,
                'property_path' => 'identificationNumber',
                'constraints' => [
                    new IdentityNumberConstraint($countryCode)
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserDto::class,
            'country_code' => null
        ]);
    }
}