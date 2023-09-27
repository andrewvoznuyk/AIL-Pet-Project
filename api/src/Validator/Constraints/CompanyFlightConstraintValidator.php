<?php

namespace App\Validator\Constraints;

use App\Entity\Aircraft;
use App\Entity\Airport;
use App\Entity\Company;
use App\Entity\CompanyFlights;
use App\Entity\Flight;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CompanyFlightConstraintValidator extends ConstraintValidator
{
    /**
     * @param Security $security
     */
    public function __construct(
        private Security $security)
    {
    }

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof CompanyFlightConstraint) {
            throw new UnexpectedTypeException($constraint, CompanyFlightConstraint::class);
        }

        if (!$value instanceof CompanyFlights) {
            throw new UnexpectedTypeException($constraint, CompanyFlights::class);
        }

        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        //check if that company belongs to user
        if ($value->getCompany()->getOwner() !== $currentUser) {
            $this->context->addViolation("Select valid company");
        }
    }
}