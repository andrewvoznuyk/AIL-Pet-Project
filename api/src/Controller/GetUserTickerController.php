<?php

namespace App\Controller;

use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @deprecated
 */
class GetUserTickerController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @return JsonResponse
     */
    #[Route('/ticket-info', name: 'get_ticket_info', methods: ['GET'])]
    public function getUserTicket(): JsonResponse
    {
        $user = $this->security->getUser();
        $tickets = $this->entityManager->getRepository(Ticket::class)->findBy(["user" => $user]);

        $formattedTickets = [];

        foreach ($tickets as $ticket) {
            $departure = $ticket->getFlight()->getDeparture();
            $arrival = $ticket->getFlight()->getArrival();
            $fromLocation = $ticket->getFlight()->getFromLocation()->getAirport();
            $toLocation = $ticket->getFlight()->getToLocation()->getAirport();

            $formattedTickets[] = [
                'name'         => $ticket->getName(),
                'surname'      => $ticket->getSurname(),
                'place'        => $ticket->getPlace(),
                'class'        => $ticket->getClass(),
                'departure'    => $departure->format('Y-m-d H:i:s'),
                'arrival'      => $arrival->format('Y-m-d H:i:s'),
                'fromLocation' => $fromLocation->getName(),
                'toLocation'   => $toLocation->getName()
            ];
        }

        return new JsonResponse($formattedTickets, Response::HTTP_OK);
    }

}