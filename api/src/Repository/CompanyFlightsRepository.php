<?php

namespace App\Repository;

use App\Entity\CompanyFlights;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyFlights>
 *
 * @method CompanyFlights|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyFlights|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyFlights[]    findAll()
 * @method CompanyFlights[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyFlightsRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyFlights::class);
    }

    public function isExists(CompanyFlights $companyFlight) : bool{
        return !empty($this->_em->getRepository(CompanyFlights::class)
            ->findOneBy(
                [
                    "airport" => $companyFlight->getAirport(),
                    "company" => $companyFlight->getCompany()
                ]));

    }

}
