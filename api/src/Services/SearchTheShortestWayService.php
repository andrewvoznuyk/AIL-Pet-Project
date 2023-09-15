<?php

namespace App\Services;

use App\Entity\AircraftModel;
use App\Entity\Airport;
use App\Entity\Flight;
use App\Services\SearchingModel\Dijkstra;
use App\Services\SearchingModel\Graph;
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

class SearchTheShortestWayService
{

    /**
     * @var Graph
     */
    private Graph $graph;

    /**
     * @var GetMilesService
     */
    private GetMilesService $getMilesService;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param GetMilesService $getMilesService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(GetMilesService $getMilesService, EntityManagerInterface $entityManager)
    {
        $this->graph = new Graph();
        $this->getMilesService = $getMilesService;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $airports
     * @return void
     */
    private function addAirportsToGraph(array $airports): void
    {
        for ($i = 0; $i < count($airports); $i++) {
            $this->graph->addAirport($airports[$i]);
        }
    }

    /**
     * @param array $flights
     * @return void
     * @throws Exception
     */
    private function addWays(array $flights): void
    {
        for ($i = 0; $i < count($flights); $i++) {
            /** @var Flight $flight */
            $flight = $flights[$i];
            $frAirport = $this->entityManager->getRepository(Airport::class)->findOneBy(["name" => $flight->getFromLocation()]);
            $toAirport = $this->entityManager->getRepository(Airport::class)->findOneBy(["name" => $flight->getToLocation()]);

            $this->graph->addWay($frAirport->getName(), $toAirport->getName(), $this->getMilesService->getMilesFromCityAtoCityB($frAirport->getId(), $toAirport->getId()));
        }
    }

    /**
     * @param array $airports
     * @param array $flights
     * @return string
     * @throws Exception
     */
    function getWay(array $airports, array $flights): string
    {
        $this->addAirportsToGraph($airports);
        $this->addWays($flights);

        $dijkstra = new Dijkstra($this->graph);

        return $dijkstra->getShortestPath('A', "B");
    }

}