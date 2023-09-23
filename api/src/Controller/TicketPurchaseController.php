<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\Ticket;
use App\Entity\User;
use App\Services\CalculateTicketPriceService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class TicketPurchaseController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;
    private CalculateTicketPriceService $calculateTicketPriceService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param DenormalizerInterface $denormalizer
     * @param CalculateTicketPriceService $calculateTicketPriceService
     */
    public function __construct(
        EntityManagerInterface      $entityManager,
        ValidatorInterface          $validator,
        DenormalizerInterface       $denormalizer,
        CalculateTicketPriceService $calculateTicketPriceService
    )
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->denormalizer = $denormalizer;
        $this->calculateTicketPriceService = $calculateTicketPriceService;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    #[IsGranted(User::ROLE_USER)]
    #[Route('/tickets/purchase', name: 'app_tickets_purchase', methods: "POST")]
    public function purchaseTickets(Request $request): Response
    {
        $content = $request->getContent();

        if (!$content) {
            throw new UnprocessableEntityHttpException("Wrong data type");
        }

        $requestData = json_decode($request->getContent(), true);

        foreach ($requestData as $ticketData) {
            $ticket = $this->createTicket($ticketData);
            $this->entityManager->persist($ticket);
        }

        $this->entityManager->flush();

        return new JsonResponse("Created", 201);
    }

    /**
     * @param $ticketData
     * @return Ticket
     * @throws ExceptionInterface
     * @throws Exception
     */
    private function createTicket($ticketData): Ticket
    {
        /** @var Ticket $ticket */
        $ticket = $this->denormalizer->denormalize($ticketData, Ticket::class, "array");

        $ticket->setUser($this->getUser());
        $ticket->setPrice($this->calculateTicketPriceService->calculateTicketPrice($ticket));

        $this->validator->validate($ticket);

        return $ticket;
    }

}
