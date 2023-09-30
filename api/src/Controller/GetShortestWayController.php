<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Entity\Flight;
use App\Services\SearchTheShortestWayService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetShortestWayController extends AbstractController
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param SearchTheShortestWayService $searchTheShortestWayService
     */
    public function __construct(private EntityManagerInterface $entityManager, private SearchTheShortestWayService $searchTheShortestWayService)
    {
    }

    /**
     * @throws Exception
     */
    #[Route('/find-way', name: 'get_shortest_way', methods: ['GET'])]
    public function getOwnerCompany(Request $request): JsonResponse
    {
        $fromLocation = $request->query->get('fromLocation');
        $toLocation = $request->query->get('toLocation');
        if (!isset(
            $fromLocation,
            $toLocation
        )) {
            throw new Exception();
        }

        $fromCity = $this->entityManager->getRepository(Airport::class)->findBy(["city" => $fromLocation]);
        $toCity = $this->entityManager->getRepository(Airport::class)->findBy(["city" => $toLocation]);

        if ($fromCity === $toCity || !isset($fromCity) || !isset($toCity)) {
            return new JsonResponse([], Response::HTTP_OK);
        }

        $flights = $this->entityManager->getRepository(Flight::class)->findBy(["isCompleted" => 0]);
        $neededFlights = [];

        foreach ($flights as $flight) {
            if (strtotime($flight->getDeparture()->format('Y-m-d H:i:s')) > strtotime(date("Y-m-d H:i:s"))) {
                $neededFlights[] = $flight;
            }
        }

        $way = $this->searchTheShortestWayService->getArrayOfWays($fromCity, $toCity, $neededFlights);

        return new JsonResponse($way, Response::HTTP_OK);
    }

}