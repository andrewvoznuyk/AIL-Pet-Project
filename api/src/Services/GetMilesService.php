<?php

namespace App\Services;

use App\Entity\Airport;

class GetMilesService
{

    private const EARTH_RADIUS = 6371.0088;

    /**
     * @param $lon1
     * @param $lat1
     * @param $lon2
     * @param $lat2
     * @return float
     */
    public function countKilometers($lon1, $lat1, $lon2, $lat2): float
    {
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(self::EARTH_RADIUS * $c,2);
    }

    /**
     * @param Airport $departureAirportId
     * @param Airport $arrivalAirportId
     * @return float
     */
    public function getMilesFromCityAtoCityB(Airport $departureAirportId, Airport $arrivalAirportId): float
    {
        return $this->countkilometers($departureAirportId->getLon(), $departureAirportId->getLat(), $arrivalAirportId->getLon(), $arrivalAirportId->getLat());
    }

}