<?php

namespace App\Controller;

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
        $flights = $this->entityManager->getRepository(Flight::class)->findAll();

        $way = $this->searchTheShortestWayService->getWay($flights);

        return new JsonResponse($way, Response::HTTP_OK);
    }

}