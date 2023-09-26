<?php

namespace App\Validator\Constraints;

use App\Entity\Ticket;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TicketConstraintValidator extends ConstraintValidator
{

    private Security $security;
    private EntityManagerInterface $entityManager;

    /**
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof TicketConstraint) {
            throw new UnexpectedTypeException($constraint, TicketConstraint::class);
        }

        if (!$value instanceof Ticket) {
            throw new UnexpectedTypeException($constraint, Ticket::class);
        }

        $place = $value->getPlace();
        $flight = $value->getFlight();

        //check if place has valid number
        $totalPlaces = $value->getFlight()->getAircraft()->getPlacesCount();
        $this->checkIsPlaceValid($place, $totalPlaces);

        //check if plane can accept this luggage
        $maxLuggageMass = 1000;//$value->getFlight()->getAircraft()->getModel()->ge;
        $currentMass = $this->entityManager->getRepository(Ticket::class)->getTotalLuggageMassOf($flight);

        if ($currentMass + $value->getLuggageMass() > $maxLuggageMass) {
            $this->context->addViolation("Plane overweighted");
        }

        //check if this place wasn't selected by another user
        if (!empty($this->entityManager->getRepository(Ticket::class)
            ->getTicketByPlace($place, $flight))) {
            $this->context->addViolation("Place {$place} was already booked!");
        }

        //check if ticket will be bought for the future flight
        $now = new DateTime();

        if ($flight->getDeparture() < $now) {
            $this->context->addViolation("Flight was already launched, cannot buy ticket");
        }
    }

    private function checkIsPlaceValid(int $place, int $totalPlaces): void
    {
        //place number always > 0, cannot be skipped num (13) and cannot be grater than places totally
        if (!($place > 0 &&
            $place <= $totalPlaces + $this->getSkippedPlacesCount($totalPlaces) &&
            !in_array($place, Ticket::SKIPPED_PLACES)
        )) {
            $this->context->addViolation("Wrong place number");
        }
    }

    protected function getSkippedPlacesCount($totalPlaces): int
    {
        $count = 0;

        for ($i = 0; $i < count(Ticket::SKIPPED_PLACES); $i++) {
            if ($totalPlaces >= Ticket::SKIPPED_PLACES[$i]) {
                $count++;
            } else {
                break;
            }
        }

        return $count;
    }

}