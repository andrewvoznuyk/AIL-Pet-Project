<?php

namespace App\Services;

use App\Entity\Ticket;
use DateTime;
use Exception;

class CalculateTicketPriceService
{
    private const FLUE_PRICE = 0.4;
    private const PRICE_INCREASE = 0.1;
    private const PERCENT = 100;
    private const MIN_AZIMUTH = 0;
    private const MAX_AZIMUTH = 180;

    /**
     * @var GetMilesService
     */
    private GetMilesService $getMilesService;

    /**
     * @param GetMilesService $getMilesService
     */
    public function __construct(GetMilesService $getMilesService)
    {
        $this->getMilesService = $getMilesService;
    }

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

        $price = $km * self::FLUE_PRICE * (1 / (1 + $interval->days * self::PRICE_INCREASE)) * (1 + $classCoef[$class]);
        $azimuth = $this->getMilesService->calculateAzimuth($ticket->getFlight());

        if ($azimuth >= self::MIN_AZIMUTH && $azimuth < self::MAX_AZIMUTH)
            $price += $price / self::PERCENT;

        if ($price < $initPrice)
            $price = $initPrice;

        return  $price;
    }
}