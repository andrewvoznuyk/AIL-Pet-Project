<?php

namespace App\Services;

use App\Entity\Airport;
use App\Entity\Flight;
use DateTime;
use DateTimeInterface;
use Exception;

class GetMilesService
{

    private const EARTH_RADIUS = 6371.0088;
    private const HOUR_IN_SECONDS = 3600;
    private const DEGREES_LIMIT = 360;

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

        return round(self::EARTH_RADIUS * $c, 2);
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

    /**
     * @param Flight $flight
     * @return DateTimeInterface
     * @throws Exception
     */
    public function calculateFlightArrival(Flight $flight): DateTimeInterface
    {
        $aircraftSpeed = $flight->getAircraft()->getModel()->getCruiseSpeedKmph();

        $timeInHour = $flight->getDistance() / $aircraftSpeed;
        $timeStamp = $timeInHour * self::HOUR_IN_SECONDS;
        $departureTime = $flight->getDeparture()->getTimestamp();
        $arrivalTimeStamp = $departureTime + $timeStamp;

        return new DateTime("@$arrivalTimeStamp");
    }

    /**
     * @param Flight $flight
     * @return int
     */
    function calculateAzimuth(Flight $flight): int
    {
        $fromAirport = $flight->getFromLocation()->getAirport();
        $toAirPort = $flight->getToLocation()->getAirport();
        $fromLat = $fromAirport->getLat(); $fromLon = $fromAirport->getLon();
        $toLat = $toAirPort->getLat(); $toLon = $toAirPort->getLon();

        $lat1 = deg2rad($fromLat);
        $lon1 = deg2rad($fromLon);
        $lat2 = deg2rad($toLat);
        $lon2 = deg2rad($toLon);

        $dLon = $lon2 - $lon1;

        $y = sin($dLon) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLon);
        $azimuth = atan2($y, $x);

        $azimuth = rad2deg($azimuth);

        return ($azimuth + self::DEGREES_LIMIT) % self::DEGREES_LIMIT;
    }
}