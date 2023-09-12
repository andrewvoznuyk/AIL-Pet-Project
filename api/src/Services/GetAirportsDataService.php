<?php

namespace App\Services;

use App\Entity\AircraftModel;
use App\Entity\Airport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAirportsDataService
{
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param HttpClientInterface $client
     * @param EntityManagerInterface $entityManager
     * @param DenormalizerInterface $denormalizer
     * @param ValidatorInterface $validator
     */
    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer, ValidatorInterface $validator)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
    }

    /**
     * @return void
     * @throws ExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function airportsApiParse(): void
    {
        $response = $this->client->request('GET', 'https://flight-radar1.p.rapidapi.com/airports/list', [
            'headers' => [
                'X-RapidAPI-Key' => '47e2b070fdmsh932f2501fdcf894p14620fjsn62d151a62acc',
                'X-RapidAPI-Host' => 'flight-radar1.p.rapidapi.com']
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $requestData = json_decode($content, true);

        $airportData = $requestData['rows'];

        for ($i = 0; $i < count($airportData); $i++) {
            $airport = new Airport();

            if (!is_double($airportData[$i]['lon']) or !is_double($airportData[$i]['lat'])) {
                $airportData[$i]['lon'] = (double)$airportData[$i]['lon'];
                $airportData[$i]['lat'] = (double)$airportData[$i]['lat'];
            }

            $airport = $this->denormalizer->denormalize($airportData[$i], Airport::class, "array");
            $errors = $this->validator->validate($airportData[$i]);

            $this->entityManager->persist($airport);
            $this->entityManager->flush($airport);
        }
    }

    /**
     * @return void
     * @throws ClientExceptionInterface
     * @throws ExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function aircraftsApiParse(): void
    {
        $response = $this->client->request('GET', 'https://flight-radar1.p.rapidapi.com/aircrafts/list', [
            'headers' => [
                'X-RapidAPI-Key' => '47e2b070fdmsh932f2501fdcf894p14620fjsn62d151a62acc',
                'X-RapidAPI-Host' => 'flight-radar1.p.rapidapi.com']
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $requestData = json_decode($content, true);

        $aircraftData = $requestData['rows'];
        for ($i = 0; $i < count($aircraftData); $i++) {

            for ($j = 0; $j < count($aircraftData[$i]['models'])-1; $j++)

            $aircraft = new AircraftModel();

            $airport = $this->denormalizer->denormalize($aircraftData[$i]['models'][$j], AircraftModel::class, "array");
            $errors = $this->validator->validate($aircraftData[$i]);
        }
    }
}