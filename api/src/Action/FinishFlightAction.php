<?php

namespace App\Action;

use App\Entity\Flight;
use App\Entity\Ticket;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class FinishFlightAction
{

    private const BONUS_PERCENTAGE = 10;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Flight $data
     * @return Flight
     */
    public function __invoke(Flight $data): Flight
    {
        $now = new DateTime();

        if ($data->getArrival() < $now) {
            $data->setIsCompleted(true);
        }

        $bonus = $data->getDistance() * self::BONUS_PERCENTAGE / 100;
        $tickets = $this->entityManager->getRepository(Ticket::class)->findBy(['flight' => $data]);

        foreach ($tickets as $ticket)
        {
            $user = $ticket->getUser();
            $user->setMileBonuses($user->getMileBonuses() + intval(floor($bonus)));
        }

        return $data;
    }

}