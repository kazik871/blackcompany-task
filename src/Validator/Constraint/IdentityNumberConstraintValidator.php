<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 19:18
 */

namespace App\Validator\Constraint;


use App\Domain\Factory\IdentityNumberAbstractFactory;
use App\Domain\Model\CountryCode;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IdentityNumberConstraintValidator extends ConstraintValidator
{
    /**
     * @var IdentityNumberAbstractFactory
     */
    private $factory;

    public function __construct(IdentityNumberAbstractFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var IdentityNumberConstraint $constraint */
        $countryCode = $constraint->countryCode();

        if (!CountryCode::has($countryCode)) {
            $this->context->addViolation($constraint->cannotDetermineCountry);
            return;
        }

        try {
            $this->factory->create(CountryCode::get($countryCode), $value);
        } catch (\DomainException $exception) {
            $this->context->addViolation($constraint->invalidNumberMessage);
        }
    }
}