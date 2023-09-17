<?php

namespace App\EntityListener;

use App\Entity\Flight;
use App\Services\GetMilesService;
use Doctrine\ORM\Event\ListenersInvoker;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FlightEntityListener
{
    /**
     * @param Flight $flight
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(Flight $flight, LifecycleEventArgs $eventArgs): void
    {
        $getMilesService = new GetMilesService();
        $distance = $getMilesService->getMilesFromCityAtoCityB($flight->getFromLocation()->getAirport(), $flight->getToLocation()->getAirport());
        $flight->setDistance($distance);
    }

}