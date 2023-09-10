<?php

namespace App\Repository;

use App\Entity\CompanyWorker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyWorker>
 *
 * @method CompanyWorker|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyWorker|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyWorker[]    findAll()
 * @method CompanyWorker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyWorker::class);
    }

//    /**
//     * @return CompanyManager[] Returns an array of CompanyManager objects
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

//    public function findOneBySomeField($value): ?CompanyManager
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
