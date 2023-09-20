<?php

namespace App\Services;

use App\Entity\Airport;
use App\Entity\Flight;
use App\Services\SearchingModel\Dijkstra;
use App\Services\SearchingModel\Graph;
use Exception;
use phpDocumentor\Reflection\Types\Array_;

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
     */
    private function addWays(array $flights): void
    {
        for ($i = 0; $i < count($flights); $i++) {
            /** @var Flight $flight */
            $flight = $flights[$i];

            $frAirport = $flight->getFromLocation()->getAirport();
            $toAirport = $flight->getToLocation()->getAirport();
            $this->graph->addWay($frAirport, $toAirport, $flight->getDistance());
        }
    }

    /**
     * @param array $flights
     * @param Airport $fromAirport
     * @param Airport $toAirport
     * @param Dijkstra $dijkstra
     * @return array
     */
    private function getWays(array $flights, Airport $fromAirport, Airport $toAirport, Dijkstra $dijkstra): array
    {
        $this->addAirportsToGraph($this->getAirports($flights));
        $this->addWays($flights);

        return $this->returnFlights(array_reverse($dijkstra->getShortestPath("{$fromAirport->getId()}", "{$toAirport->getId()}")), $flights);
    }

    /**
     * @param array $fromCity
     * @param array $toCity
     * @param array $flights
     * @return string[]
     */
    public function getArrayOfWays(array $fromCity, array $toCity, array $flights): array
    {
        $dijkstra = new Dijkstra($this->graph);
        $arr = ["city"];
        for ($i = 0; $i < count($fromCity); $i++) {
            for ($j = 0; $j < count($toCity); $j++) {
                $way = $this->getWays($flights, $fromCity[$i], $toCity[$j], $dijkstra);
                if ($way != []) {
                    $arr["flights"] = $way;
                }
            }
        }
        return $arr;
    }

    /**
     * @param array $airportsId
     * @param array $flights
     * @return array
     */
    private function returnFlights(array $airportsId, array $flights): array
    {
        $neededFlights = [];
        $airportsId[] = [""];

        for ($i = 0; $i < count($flights); $i++) {
            for ($j = 0; $j < count($airportsId); $j++) {
                if ($flights[$i]->getFromLocation()->getAirport()->getId() == $airportsId[$j] && $flights[$i]->getToLocation()->getAirport()->getId() == $airportsId[$j + 1]) {

                    $neededFlights[] = $flights[$i];
                }
            }
        }

/*        for ($i = 0; $i < count($flights); $i++) {
            for ($j = 0; $j < count($airportsId); $j++) {
                for($k = 0; $k < count($flights); $k++){
                    if ($flights[$i]->getFromLocation()->getAirport()->getId() == $airportsId[$j] && $flights[$i]->getToLocation()->getAirport()->getId() == $airportsId[$j+1]){
                        $holeArray[$k] = $flights[$i];
                        if($holeArray->getDistance()) {
                            $neededFlights[] = $flights[$i];
                        }
                    }
                }
            }
        }*/

        return $neededFlights;
    }

    /**
     * @param array $flights
     * @return array
     */
    private function getAirports(array $flights): array
    {
        $airports = [];

        /** @var Flight $flight */
        foreach ($flights as $flight) {
            $airports[] = $flight->getFromLocation()->getAirport();
            $airports[] = $flight->getToLocation()->getAirport();
        }
        return $airports;
    }

}