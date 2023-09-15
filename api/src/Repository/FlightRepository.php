<?php

namespace App\Repository;

use App\Entity\Flight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flight>
 *
 * @method Flight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flight[]    findAll()
 * @method Flight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flight::class);
    }

    /**
     * @param $from
     * @param $to
     * @return array
     */
    public function findAllByFilter($from, $to): array
    {
        $qb = $this->createQueryBuilder("flight");

        return $this->createQueryBuilder("flight")
            ->innerJoin('flight.fromLocation', 'fromCompanyFlights')
            ->innerJoin('flight.toLocation', 'toCompanyFlights')
            ->innerJoin('fromCompanyFlights.airport', 'fromAirport')
            ->innerJoin('toCompanyFlights.airport', 'toAirport')
            ->andWhere($qb->expr()->eq('fromAirport.city', ':from'))
            ->andWhere($qb->expr()->eq('fromAirport.city', ':to'))
//          ->andWhere($qb->expr()->gte('f.departureDate', ':departureDate'))
            ->setParameter('from', $from ? '%' . $from . '%' : '')
            ->setParameter('to', $to ? '%' . $to . '%' : '')
//          ->setParameter('departureDate', $departureDate ? '%' . $departureDate . '%' : '')
            ->orderBy('flight.departure', 'DESC')
            ->getQuery()->getResult();
    }

}
