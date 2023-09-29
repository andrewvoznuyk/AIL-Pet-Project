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

class AircraftConstraintValidator extends ConstraintValidator
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
        if (!$constraint instanceof AircraftConstraint) {
            throw new UnexpectedTypeException($constraint, AircraftConstraint::class);
        }

        if (!$value instanceof Aircraft) {
            throw new UnexpectedTypeException($constraint, Aircraft::class);
        }

        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        if($value->getCompany()) {
            //check if that company belongs to user
            if ($value->getCompany()->getOwner() !== $currentUser) {
                $this->context->addViolation("Select valid company");
            }
        }

        //check if plane has only positive count of places
        foreach ($value->getPlaces() as $key => $v) {
            if ($v < 0 || !is_int($v)) {
                $this->context->addViolation("Places could be only positive integers");
                break;
            }
        }

        //check if plane has only positive columns
        foreach ($value->getColumns() as $c){
            if ($c < 0 || !is_int($c)) {
                $this->context->addViolation("Columns could be only positive integers");
                break;
            }
        }
    }

}