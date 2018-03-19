<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 19:16
 */

namespace App\Validator\Constraint;


use Symfony\Component\Validator\Constraint;

class IdentityNumberConstraint extends Constraint
{
    /**
     * @var string
     */
    public $invalidNumberMessage = 'Identification number is invalid';
    /**
     * @var string
     */
    public $cannotDetermineCountry = 'Cannot determine which country the number is';
    /**
     * @var string
     */
    private $countryCode;

    public function __construct($countryCode)
    {
        parent::__construct([]);
        $this->countryCode = $countryCode;
    }

    public function countryCode()
    {
        return $this->countryCode;
    }

    public function validatedBy()
    {
        return get_class() . 'Validator';
    }
}