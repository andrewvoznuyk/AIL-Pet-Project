<?php

namespace App\Services\SearchingModel;

use App\Entity\Airport;
use Generator;

class Graph
{
    /**
     * @var array
     */
    private array $ways;

    /**
     * Graph constructor.
     */
    public function __construct()
    {
        $this->ways = [];
    }

    /**
     * @param Airport $airport
     */
    public function addAirport(Airport $airport): void
    {
        $this->ways[$airport->getId()] = [];
    }

    /**
     * @param Airport $initialAirport
     * @param Airport $terminalAirport
     * @param string $distance
     */
    public function addWay(Airport $initialAirport, Airport $terminalAirport, string $distance): void
    {
        $this->addEdge($initialAirport, $terminalAirport, $distance);
        $this->addEdge($terminalAirport, $initialAirport, $distance);
    }

    /**
     * @return iterable
     */
    public function getAirports(): iterable
    {
        foreach (array_keys($this->ways) as $airportId) {
            yield $airportId;
        }
    }

    /**
     * @param string $initialAirport
     * @return Generator
     */
    public function getWays(string $initialAirport): Generator
    {
        foreach ($this->ways[$initialAirport] as $terminalAirport => $distance) {
            yield $terminalAirport => $distance;
        }
    }

    /**
     * @param Airport $initialAirport
     * @param Airport $terminalAirport
     * @param string $distance
     */
    private function addEdge(Airport $initialAirport, Airport $terminalAirport, string $distance): void
    {
        $this->ways[$initialAirport->getId()][$terminalAirport->getId()] = $distance;
    }
}
