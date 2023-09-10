<?php

namespace App\Repository;

use App\Entity\AircraftModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AircraftModel>
 *
 * @method AircraftModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method AircraftModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method AircraftModel[]    findAll()
 * @method AircraftModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AircraftModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AircraftModel::class);
    }

//    /**
//     * @return AircraftModel[] Returns an array of AircraftModel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AircraftModel
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
