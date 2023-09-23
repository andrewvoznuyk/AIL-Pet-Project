<?php

namespace App\Services;

use App\Entity\Ticket;
use DateTime;
use Exception;

class CalculateTicketPriceService
{
    private const FLUE_PRICE = 0.4;
    private const PRICE_INCREASE = 0.1;

    /**
     * @throws Exception
     */
    public function calculateTicketPrice(Ticket $ticket) : float
    {
        $km = $ticket->getFlight()->getDistance();
        $classCoef = $ticket->getFlight()->getPlacesCoefs();
        $class = $ticket->getClass();

        $nowDateTime = new DateTime();
        $departureDateTime = $ticket->getFlight()->getDeparture();
        $interval = $nowDateTime->diff($departureDateTime);

        $initPrice = $ticket->getFlight()->getInitPrices()[$class];

        $price = $km * self::FLUE_PRICE * (1 / (1 + $interval->days * self::PRICE_INCREASE)) * (1 + $classCoef[0][$class]);
        if ($price < $initPrice)
            $price = $initPrice;

        return  $price;
    }
}