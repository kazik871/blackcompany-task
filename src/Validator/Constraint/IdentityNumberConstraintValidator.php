<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 19:18
 */

namespace App\Validator\Constraint;


use App\Domain\Factory\IdentityNumberFactory;
use App\Domain\Model\CountryCode;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IdentityNumberConstraintValidator extends ConstraintValidator
{
    /**
     * @var IdentityNumberFactory
     */
    private $factories;

    public function __construct(IdentityNumberFactory ...$factories)
    {
        $this->factories = $factories;
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

        foreach ($this->factories as $factory) {
            if ($factory->fitsTo(CountryCode::get($countryCode))) {
                try {
                    $factory->create($value);
                } catch (\DomainException $exception) {
                    $this->context->addViolation($constraint->invalidNumberMessage);
                }

                return;
            }
        }

        throw new \RuntimeException(
            sprintf('Can not find IdentityNumberFactory for country code: %s', $countryCode)
        );
    }
}