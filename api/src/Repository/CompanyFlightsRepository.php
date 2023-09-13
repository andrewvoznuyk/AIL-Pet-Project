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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyFlights::class);
    }

//    /**
//     * @return CompanyFlights[] Returns an array of CompanyFlights objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompanyFlights
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
