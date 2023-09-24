<?php

namespace App\EntityListener;

use App\Entity\Ticket;
use App\Services\MailerService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class TicketEntityListener
{
    /**
     * @var MailerService
     */
    private MailerService $mailerService;

    /**
     * @param MailerService $mailerService
     */
    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function postPersist(Ticket $ticket, LifecycleEventArgs $eventArgs): void
    {
        $user=[
            'email'=>$ticket->getUser()->getEmail(),
            'name'=>$ticket->getUser()->getName(),
            'surName'=>$ticket->getUser()->getSurname()
        ];

        $location=[
            'from'=>$ticket->getFlight()->getFromLocation()->getAirport(),
            'to'=>$ticket->getFlight()->getFromLocation()->getAirport(),
            'departure'=>$ticket->getFlight()->getDeparture(),
            'arrival'=>$ticket->getFlight()->getArrival()
        ];

        $aircraft=[
            'model'=>$ticket->getFlight()->getAircraft()->getModel(),
            'number'=>$ticket->getFlight()->getAircraft()->getSerialNumber(),
            'place'=>$ticket->getPlace(),
            'companyName'=>$ticket->getFlight()->getAircraft()->getCompany()->getName()
        ];

        $this->mailerService->SendMailFunc($user,$location,$aircraft);
    }
}