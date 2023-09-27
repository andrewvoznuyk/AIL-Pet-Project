<?php

namespace App\Repository;

use App\Entity\Flight;
use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 *
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /**
     * @param Flight $flight
     * @return int|null
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getTotalLuggageMassOf(Flight $flight): ?int
    {
        return $this->createQueryBuilder("ticket")
            ->select("SUM(ticket.luggageMass) AS weight")
            ->where("ticket.flight = :flight")
            ->setParameter("flight", $flight)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $place
     * @param Flight $flight
     * @return Ticket|null
     * @throws NonUniqueResultException
     */
    public function getTicketByPlace(int $place, Flight $flight): ?Ticket
    {
        return $this->createQueryBuilder("ticket")
            ->select("ticket")
            ->where("ticket.flight = :flight")
            ->andWhere("ticket.place = :place")
            ->setParameter("flight", $flight)
            ->setParameter("place", $place)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Flight $flight
     * @return array
     */
    public function getSoldTickets(Flight $flight): array
    {
        return $this->createQueryBuilder("ticket")
            ->select("ticket.place")
            ->where("ticket.flight = :flight")
            ->setParameter("flight", $flight)
            ->getQuery()
            ->getResult();
    }

}
