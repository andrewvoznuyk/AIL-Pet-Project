<?php

namespace App\Services;

use App\Entity\Flight;
use App\Services\SearchingModel\Dijkstra;
use App\Services\SearchingModel\Graph;
use Exception;

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
     * @param GetMilesService $getMilesService
     */
    public function __construct(GetMilesService $getMilesService)
    {
        $this->graph = new Graph();
        $this->getMilesService = $getMilesService;
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

            $frAirport = $flight->getFromLocation()->getAirport();
            $toAirport = $flight->getToLocation()->getAirport();
            $this->graph->addWay($frAirport, $toAirport, $this->getMilesService->getMilesFromCityAtoCityB($frAirport, $toAirport));
        }
    }

    /**
     * @param array $airports
     * @param array $flights
     * @return string
     * @throws Exception
     */
    public function getWay(array $flights): array
    {
        $this->addAirportsToGraph($this->getAirports($flights));
        $this->addWays($flights);

        $dijkstra = new Dijkstra($this->graph);

/*        return $dijkstra->getShortestPath('A Coruna Airport', "Aalborg Airport");*/
        return $this->returnFlights($dijkstra->getShortestPath('A Coruna Airport', "Aalborg Airport"), $flights);
    }

    private function returnFlights(array $airportsNames, array $flights): array
    {
        $neededFlights = [];

        for ($i = 0; $i < count($flights); $i++) {
            for ($j = 0; $j < count($airportsNames); $j++){
                if ($flights[$i]->getToLocation()->getAirport()->getName() === $airportsNames[$j] && $flights[$i]->getToLocation()->getAirport()->getName() === $airportsNames[$j++])
                {
                    $neededFlights[] = $flights[$i];
                }
            }
        }

        return $neededFlights;
    }

    private function getAirports(array $flights): array
    {
        $airports = [];

        /** @var Flight $flight */
        foreach ($flights as $flight) {
            $airports[] = $flight->getToLocation()->getAirport();
            $airports[] = $flight->getFromLocation()->getAirport();
        }
        return $airports;
    }

}