<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Entity\Company;
use App\Entity\Flight;
use App\Services\SearchTheShortestWayService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class GetShortestWayController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private SearchTheShortestWayService $searchTheShortestWayService;

    public function __construct(EntityManagerInterface $entityManager, SearchTheShortestWayService $searchTheShortestWayService)
    {
        $this->entityManager = $entityManager;
        $this->searchTheShortestWayService = $searchTheShortestWayService;
    }

    /**
     * @throws Exception
     */
    #[Route('/find-way', name: 'get_shortest_way', methods: ['GET'])]
    public function getOwnerCompany(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        if (!isset(
            $requestData["fromLocation"],
            $requestData["toLocation"]
        )){
            throw new Exception();
        }

        $fromCity = $this->entityManager->getRepository(Airport::class)->findBy(["city"=>$requestData["fromLocation"]]);
        $toCity = $this->entityManager->getRepository(Airport::class)->findBy(["city"=>$requestData["toLocation"]]);

        $flights = $this->entityManager->getRepository(Flight::class)->findAll();

        $way = $this->searchTheShortestWayService->getArrayOfWays($fromCity, $toCity, $flights);

        return new JsonResponse($way, Response::HTTP_OK);
    }

}