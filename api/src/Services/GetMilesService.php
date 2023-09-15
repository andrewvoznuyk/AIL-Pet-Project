<?php

namespace App\Services;

use App\Entity\AircraftModel;
use App\Entity\Airport;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetMilesService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param HttpClientInterface $client
     * @param EntityManagerInterface $entityManager
     * @param DenormalizerInterface $denormalizer
     * @param ValidatorInterface $validator
     */
    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
    }

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

        $earthRadius = 6371.0088;

        return $earthRadius * $c;
    }


    /**
     * @param $departureAirportId
     * @param $arrivalAirportId
     * @return float
     * @throws Exception
     */
    public function getMilesFromCityAtoCityB($departureAirportId, $arrivalAirportId): float
    {
        $departurePoint = $this->entityManager->getRepository(Airport::class, true)->findOneBy($departureAirportId);

        if (!$departurePoint) {
            throw new Exception("{$departureAirportId} does not exist");
        }

        $arrivalPoint = $this->entityManager->getRepository(Airport::class, true)->findOneBy($arrivalAirportId);

        if (!$arrivalPoint) {
            throw new Exception("{$arrivalAirportId} does not exist");
        }

        return $this->countkilometers($departurePoint->getLon(), $departurePoint->getLat(), $arrivalPoint->getLon(), $arrivalPoint->getLat());
    }

}