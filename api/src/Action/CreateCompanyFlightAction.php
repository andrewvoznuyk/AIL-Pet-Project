<?php

namespace App\Action;

use ApiPlatform\Core\Bridge\Symfony\Validator\Validator;
use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\CompanyFlights;
use App\Entity\CompanyIncome;
use App\Entity\Flight;
use App\Entity\Ticket;
use App\Entity\WebsiteIncome;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CreateCompanyFlightAction
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface     $validator,

    )
    {
    }

    /**
     * @param CompanyFlights $data
     * @return CompanyFlights
     */
    public function __invoke(CompanyFlights $data): CompanyFlights
    {
        if ($this->entityManager->getRepository(CompanyFlights::class)->isExists($data)) {
            throw new UnprocessableEntityHttpException("This path is already exists");
        }

        $this->validator->validate($data);

        return $data;
    }

}