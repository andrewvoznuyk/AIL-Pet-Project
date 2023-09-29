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

class FlightConstraintValidator extends ConstraintValidator
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security               $security)
    {
    }

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

        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        //check if two locations are not the same
        if ($value->getFromLocation() === $value->getToLocation()) {
            $this->context->addViolation("From and To cannot be the same place");
        }

        //check if plane belongs to the same company
        if (empty($this->entityManager->getRepository(Aircraft::class)
            ->findOneBy(
                [
                    "id"      => $value->getAircraft()->getId(),
                    "company" => $currentUser->getManagerAtCompany()
                ]))) {
            $this->context->addViolation("Select valid aircraft");
        }

        //check if fromLocation belongs to the same company
        if (!$this->isAirportBelongsToCompany($value->getFromLocation(), $currentUser)) {
            $this->context->addViolation("Select valid airport to start from");
        }

        //check if toLocation belongs to the same company
        if (!$this->isAirportBelongsToCompany($value->getToLocation(), $currentUser)) {
            $this->context->addViolation("Select valid destination");
        }

        //check if flight has only positive start prices
        foreach ($value->getInitPrices() as $key => $v) {
            if ($v <= 0 || !is_numeric($v)) {
                $this->context->addViolation("Prices could be only positive numbers");
                break;
            }
        }

        //check if flight has only positive coefs
        foreach ($value->getPlacesCoefs() as $key => $v) {
            if ($v <= 0 || !is_numeric($v)) {
                $this->context->addViolation("Coefficients could be only positive numbers");
                break;
            }
        }

        //TODO: check if flight planned to the future
        //TODO: check if plane wouldn't be in another flight at the same time
    }

    private function isAirportBelongsToCompany(CompanyFlights $flight, User $currentUser): bool
    {
        return !(empty($this->entityManager->getRepository(CompanyFlights::class)
            ->findOneBy(
                [
                    "id"      => $flight->getId(),
                    "company" => $currentUser->getManagerAtCompany()
                ])));
    }

}