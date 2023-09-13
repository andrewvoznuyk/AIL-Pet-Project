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
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AirApiController extends AbstractController
{

    /**
     * @var GetAirportsDataService
     */
    private GetAirportsDataService $getAirportsData;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param GetAirportsDataService $getAirportsData
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(GetAirportsDataService $getAirportsData, EntityManagerInterface $entityManager)
    {
        $this->getAirportsData = $getAirportsData;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[Route('load-airport-data', name: 'load_airport_data', methods: ["POST","GET"])]
    public function loadAirports(Request $request): JsonResponse
    {
        if (in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())) {
            return new JsonResponse("404", Response::HTTP_NOT_FOUND);
        }

        $this->getAirportsData->airportsApiParse();

        return new JsonResponse([], Response::HTTP_OK);
    }

    #[Route('load-aircraft-data', name: 'load_aircraft_data', methods: ["POST","GET"])]
    public function loadAircrafts(Request $request): JsonResponse
    {
        if (in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())) {
            return new JsonResponse("404", Response::HTTP_NOT_FOUND);
        }

        $this->getAirportsData->aircraftsApiParse();

        return new JsonResponse([], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('test-request', name: 'test-request', methods: ["GET"])]
    public function testRequest(Request $request): JsonResponse
    {
        $requestData=json_decode($request->getContent(),true);
        $flights=$this->entityManager->getRepository(Flight::class)->findAllByFilter($requestData['from'],$requestData['to']);

        return new JsonResponse($flights, Response::HTTP_OK);
    }
}