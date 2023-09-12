<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Entity\Flight;
use App\Services\GetAirportsDataService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AirApiController extends AbstractController
{

    /**
     * @var GetAirportsDataService
     */
    private GetAirportsDataService $getAirportsData;
    private EntityManagerInterface $entityManager;

    /**
     * @param GetAirportsDataService $getAirportsData
     */
    public function __construct(GetAirportsDataService $getAirportsData, EntityManagerInterface $entityManager)
    {
        $this->getAirportsData = $getAirportsData;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('load-airport-data', name: 'load_airport_data')]
    public function loadAirports(Request $request): JsonResponse
    {
        if (in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())) {
            return new JsonResponse("404", Response::HTTP_NOT_FOUND);
        }

        $this->getAirportsData->airportsApiParse();

        return new JsonResponse([], Response::HTTP_OK);
    }
    #[Route('test-request', name: 'test-request')]
    public function testRequest(Request $request): JsonResponse
    {
        $requestData=json_decode($request->getContent(),true);
        $flights=$this->entityManager->getRepository(Flight::class)->findAllByFilter($requestData['from'],$requestData['to']);

        return new JsonResponse($flights, Response::HTTP_OK);
    }
}