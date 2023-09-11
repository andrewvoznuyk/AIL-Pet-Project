<?php

namespace App\Repository;

use App\Entity\CompanyIncome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyIncome>
 *
 * @method CompanyIncome|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyIncome|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyIncome[]    findAll()
 * @method CompanyIncome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyIncomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyIncome::class);
    }

//    /**
//     * @return CompanyIncome[] Returns an array of CompanyIncome objects
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

//    public function findOneBySomeField($value): ?CompanyIncome
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
