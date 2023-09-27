<?php

namespace App\Action;

use App\Services\GetApiDataService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetAirportApiAction
{

    /**
     * @param GetApiDataService $getAirportsData
     */
    public function __construct(private GetApiDataService $getAirportsData)
    {
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function __invoke(): JsonResponse
    {
        $this->getAirportsData->airportsApiParse();

        return new JsonResponse("Successfully done", ResponseAlias::HTTP_OK);
    }

}