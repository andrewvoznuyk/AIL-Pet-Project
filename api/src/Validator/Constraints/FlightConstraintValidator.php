<?php

namespace App\Validator\Constraints;

use App\Entity\Airport;
use App\Entity\Flight;
use App\Validator\Constraints\Airport as AirportConstraint;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FlightConstraintValidator extends ConstraintValidator
{

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof FlightConstraint) {
            throw new UnexpectedTypeException($constraint, FlightConstraint::class);
        }

        if (!$value instanceof Flight) {
            throw new UnexpectedTypeException($constraint, Flight::class);
        }

        //check if two locations are not the same
        if ($value->getFromLocation() === $value->getToLocation()) {
            $this->context->addViolation("From and To cannot be the same place");
        }

        //TODO: check if plane belongs to the same company
        //TODO: check if plane wouldn't be in another flight at the same time
    }

}