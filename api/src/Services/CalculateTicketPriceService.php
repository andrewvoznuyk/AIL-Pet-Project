<?php

namespace App\Services;

use App\Entity\Flight;
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
     * @param GetMilesService $getMilesService
     */
    public function __construct(private GetMilesService $getMilesService){}

    /**
     * @throws Exception
     */
    public function calculateTicketPrice(Ticket $ticket, float $bonus) : float
    {
        return $this->calculateInitialTicketPrice($ticket->getFlight(), $ticket->getClass(), $bonus);
    }

    /**
     * @param Flight $flight
     * @return array
     */
    public function calculateInitialClassesPrices(Flight $flight) : array
    {
        $classes = $flight->getPlacesCoefs();
        $prices = [];
        foreach ($classes as $class => $key)
        {
            $prices[$class] = round($this->calculateInitialTicketPrice($flight, $class, 0),2);
        }

        return $prices;
    }

    /**
     * @param Flight $flight
     * @param string $class
     * @param int $bonus
     * @return float
     */
    public function calculateInitialTicketPrice(Flight $flight, string $class, int $bonus) : float
    {
        $km = $flight->getDistance() - $bonus;
        $classCoef = $flight->getPlacesCoefs();

        $nowDateTime = new DateTime();
        $departureDateTime = $flight->getDeparture();
        $interval = $nowDateTime->diff($departureDateTime);

        $initPrice = $flight->getInitPrices()[$class];

        $price = $km * self::FLUE_PRICE * (1 / (1 + $interval->days * self::PRICE_INCREASE)) * (1 + $classCoef[$class]);
        $azimuth = $this->getMilesService->calculateAzimuth($flight);

        if (!($azimuth >= self::MIN_AZIMUTH && $azimuth < self::MAX_AZIMUTH))
            $price += $price / self::PERCENT;

        if ($price < $initPrice)
            $price = $initPrice;

        return  $price;
    }
}