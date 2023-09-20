<?php

namespace App\Services\SearchingModel;


use Exception;

class Dijkstra
{

    private const INFINITY = 1e20;

    /**
     * @var Graph
     */
    private Graph $graph;

    /**
     * @var array
     */
    private array $used = [];

    /**
     * @var array
     */
    private array $waySums = [];

    /**
     * @var array
     */
    private array $path = [];

    /**
     * @param Graph $graph
     */
    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
    }

    /**
     * @param string $fromAirport
     * @param string $toAirport
     * @return string
     */
    public function getShortestPath(string $fromAirport, string $toAirport): array
    {
        $this->init();
        $this->waySums[$fromAirport] = 0;
        while ($currNode = $this->findNearestUnusedNode()) {
            $this->setWaySumToNextNodes($currNode);
        }

        return $this->restorePath($fromAirport, $toAirport);
    }

    /**
     * @return void
     */
    function init(): void
    {
        foreach ($this->graph->getAirports() as $airport) {
            $this->used[$airport] = false;
            $this->waySums[$airport] = self::INFINITY;
            $this->path[$airport] = '';
        }
    }

    /**
     * @return string
     */
    private function findNearestUnusedNode(): string
    {
        $nearestAirport = '';
        foreach ($this->graph->getAirports() as $airport) {
            if (!$this->used[$airport]) {
                if ($nearestAirport == '' || $this->waySums[$airport] < $this->waySums[$nearestAirport]) {
                    $nearestAirport = $airport;
                }
            }
        }
        return $nearestAirport;
    }

    /**
     * @param string $currAirport
     * @return void
     */
    private function setWaySumToNextNodes(string $currAirport): void
    {
        $this->used[$currAirport] = true;
        foreach ($this->graph->getWays($currAirport) as $nextAirport => $distance) {
            if (!$this->used[$nextAirport]) {
                $newESum = $this->waySums[$currAirport] + $distance;
                if ($newESum < $this->waySums[$nextAirport]) {
                    $this->waySums[$nextAirport] = $newESum;
                    $this->path[$nextAirport] = $currAirport;
                }
            }
        }
    }

    /**
     * @param string $fromAirport
     * @param string $toAirport
     * @return string
     */
    private function restorePath(string $fromAirport, string $toAirport): array
    {
        $path[] = $toAirport;
        while ($toAirport != $fromAirport) {
            try {
                $toAirport = $this->path[$toAirport];
                $path[] = $toAirport;
            }catch(Exception $e){return [];}
        }

        return $path;
    }

}