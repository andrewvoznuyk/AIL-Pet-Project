<?php

namespace App\EntityListener;

use App\Entity\Ticket;
use App\Services\MailerService;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TicketEntityListener
{

    /**
     * @param MailerService $mailerService
     */
    public function __construct(private MailerService $mailerService){}

    /**
     * @param Ticket $ticket
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function postPersist(Ticket $ticket, LifecycleEventArgs $eventArgs): void
    {
        $currentUser = $ticket->getUser();
        $currentFlight = $ticket->getFlight();

        $user = [
            'userEmail' => $currentUser->getEmail(),
            'name' => $ticket->getName(),
            'surName' => $ticket->getSurname()
        ];

        $location = [
            'from' => $currentFlight->getFromLocation()->getAirport()->getName(),
            'to' => $currentFlight->getFromLocation()->getAirport()->getName(),
            'departure' => $currentFlight->getDeparture()->getTimestamp(),
            'arrival' => $currentFlight->getArrival()->getTimestamp()
        ];

        $aircraft = [
            'model' => $currentFlight->getAircraft()->getModel()->getPlane(),
            'number' => $currentFlight->getAircraft()->getSerialNumber(),
            'place' => $ticket->getPlace(),
            'companyName' => $currentFlight->getAircraft()->getCompany()->getName()
        ];

        $this->mailerService->SendMailFunc($user, $location, $aircraft);
    }
}