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
     *
     */
    public function __construct()
    {
        $this->ways = [];
    }

    /**
     * @param Airport $airport
     * @return void
     */
    public function addAirport(Airport $airport): void
    {
        $this->ways[$airport->getName()] = [];
    }

    /**
     * @param Airport $initialAirport
     * @param Airport $terminalAirport
     * @param string $distance
     * @return void
     */
    public function addWay(Airport $initialAirport, Airport $terminalAirport, string $distance): void
    {
        $this->ways[$initialAirport->getName()][$terminalAirport->getName()] = $distance;
        $this->ways[$terminalAirport->getName()][$initialAirport->getName()] = $distance;
    }

    /**
     * @return iterable
     */
    public function getAirports(): iterable
    {
        foreach ($this->ways as $node => $edge) {
            yield $node;
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

}