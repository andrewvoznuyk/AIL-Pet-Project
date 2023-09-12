<?php

namespace App\Repository;

use App\Entity\WebsiteIncome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebsiteIncome>
 *
 * @method WebsiteIncome|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteIncome|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteIncome[]    findAll()
 * @method WebsiteIncome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteIncomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteIncome::class);
    }

//    /**
//     * @return WebsiteIncome[] Returns an array of WebsiteIncome objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WebsiteIncome
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
