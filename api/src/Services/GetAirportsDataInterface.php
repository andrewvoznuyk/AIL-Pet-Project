<?php

namespace App\Services;

use App\Entity\Airport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAirportsDataInterface
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
    public function airportsApiParse():void{
        $response = $this->client->request('GET', 'https://flight-radar1.p.rapidapi.com/airports/list', [
            'headers'=>[
                'X-RapidAPI-Key' => '47e2b070fdmsh932f2501fdcf894p14620fjsn62d151a62acc',
                'X-RapidAPI-Host' => 'flight-radar1.p.rapidapi.com']
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $requestData = json_decode($content, true);

        $airportData=$requestData['rows'];

        for ($i=0;$i<10;$i++){
            $airport=new Airport();
            $airport = $this->denormalizer->denormalize($airportData[$i], Airport::class, "array");
            $errors = $this->validator->validate($airportData[$i]);

            $this->entityManager->persist($airport);
            $this->entityManager->flush();
        }
    }
}