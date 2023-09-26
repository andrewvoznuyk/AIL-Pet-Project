<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\Flight;
use App\Entity\Ticket;
use App\Entity\User;
use App\Services\CalculateTicketPriceService;
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

    /**
     * @var CalculateTicketPriceService
     */
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
     * @param string $id
     * @return Response
     * @throws Exception
     */
    #[Route('/tickets/prices/{id}', name: 'tickets_prices', methods: "GET")]
    public function getTicketsPrices(string $id) : Response
    {
        $flight = $this->entityManager->getRepository(Flight::class)->findOneBy(["id" => $id]);

        if (!$flight){
            throw new Exception("There is no such a flight with id: $id .");
        }

        $ticketsPrices = $this->calculateTicketPriceService->calculateInitialClassesPrices($flight);

        return new JsonResponse($ticketsPrices, Response::HTTP_OK);

    }

    /**
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws Exception
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

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        $bonusesSum = $this->getBonusSum($requestData);
        if ($user->getMileBonuses() < $bonusesSum)
            throw new Exception("Not enough bonuses", Response::HTTP_PAYMENT_REQUIRED);

        foreach ($requestData as $ticketData) {
            $bonus = 0;
            if (isset($ticketData["bonus"]))
                $bonus = $ticketData["bonus"];
            $ticket = $this->createTicket($ticketData, $bonus);
            $this->entityManager->persist($ticket);
        }

        $user->setMileBonuses($user->getMileBonuses() - $bonusesSum);

        $this->entityManager->flush();

        return new JsonResponse("Created", Response::HTTP_CREATED);
    }

    /**
     * @throws ExceptionInterface
     * @throws Exception
     */
    private function createTicket($ticketData, float $bonus): Ticket
    {
        /** @var Ticket $ticket */
        $ticket = $this->denormalizer->denormalize($ticketData, Ticket::class, "array");

        $ticket->setUser($this->getUser());
        if ($bonus > ($ticket->getFlight()->getDistance() / 2))
            throw new Exception("To mach bonuses used", Response::HTTP_PAYMENT_REQUIRED);

        $ticket->setPrice($this->calculateTicketPriceService->calculateTicketPrice($ticket, $bonus));

        $this->validator->validate($ticket);

        return $ticket;
    }

    /**
     * @param $requestData
     * @return int
     */
    private function getBonusSum($requestData): int
    {
        $sum = 0;
        foreach ($requestData as $ticketData)
            if (isset($ticketData["bonus"]))
                $sum += $ticketData["bonus"];

        return $sum;
    }

}
