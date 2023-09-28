<?php

namespace App\Action;

use ApiPlatform\Core\Bridge\Symfony\Validator\Validator;
use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\CompanyIncome;
use App\Entity\Flight;
use App\Entity\Ticket;
use App\Entity\WebsiteIncome;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class FinishFlightAction
{

    private const BONUS_PERCENTAGE       = 10;
    private const WEBSITE_PERCENT_INCOME = 0.02;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager, private ValidatorInterface $validator)
    {
    }

    /**
     * @param Flight $data
     * @return Flight
     */
    public function __invoke(Flight $data): Flight
    {
        $now = new DateTime();

        $data->setIsCompleted(true);

        $bonus = $data->getDistance() * self::BONUS_PERCENTAGE / 100;
        $tickets = $this->entityManager->getRepository(Ticket::class)->findBy(['flight' => $data]);
        $companyFlightIncome = 0;

        foreach ($tickets as $ticket) {
            $user = $ticket->getUser();
            $user->setMileBonuses($user->getMileBonuses() + intval(floor($bonus)));
            $companyFlightIncome += $ticket->getPrice();
        }

        $companyIncome = new CompanyIncome();
        $companyIncome->setIncome($companyFlightIncome);
        $companyIncome->setFlight($data);
        $companyIncome->setDate($now);

        $this->validator->validate($companyIncome);

        $websiteIncome = new WebsiteIncome();
        $websiteIncome->setCompanyIncome($companyIncome);
        $websiteIncome->setIncome($companyFlightIncome * self::WEBSITE_PERCENT_INCOME);

        $this->entityManager->persist($companyIncome);
        $this->entityManager->persist($websiteIncome);
        $this->entityManager->flush();

        return $data;
    }

}