<?php

namespace App\Services;


use App\Entity\Flight;
use Exception;

class CalculateTicketPriceService
{

    private GetMilesService $getMilesService;

    public function __construct(GetMilesService $getMilesService)
    {
        $this->getMilesService = $getMilesService;
    }


    /**
     * @param Flight $flight
     * @return int
     * @throws Exception
     */
    public function calculateTicketPrice(Flight $flight) : int
    {
        $departureAirportId = $flight->getFromLocation()->getAirport();
        $arrivalAirportId = $flight->getToLocation()->getAirport();

        $km =  $this->getMilesService->getMilesFromCityAtoCityB($departureAirportId, $arrivalAirportId);

        $price = $km * 0.5;


        return  0;
    }
}