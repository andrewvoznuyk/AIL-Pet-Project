<?php

namespace App\EntityListener;

use App\Entity\Flight;
use App\Services\GetMilesService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Exception;

class FlightEntityListener
{

    /**
     * @param Flight $flight
     * @param LifecycleEventArgs $eventArgs
     * @return void
     * @throws Exception
     */
    public function prePersist(Flight $flight, LifecycleEventArgs $eventArgs): void
    {
        $arrivalDate = $flight->getDeparture();
        $flight->setArrival($arrivalDate);

        $getMilesService = new GetMilesService();
        $distance = $getMilesService->getMilesFromCityAtoCityB($flight->getFromLocation()->getAirport(), $flight->getToLocation()->getAirport());
        $flight->setDistance($distance);
        $flight->setArrival($getMilesService->calculateFlightArrival($flight));
    }

}