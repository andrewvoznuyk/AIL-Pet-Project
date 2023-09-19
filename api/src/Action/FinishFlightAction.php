<?php

namespace App\Action;

use App\Entity\Flight;
use DateTime;

class FinishFlightAction
{

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

        return $data;
    }

}