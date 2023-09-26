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

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyIncome::class);
    }

    /**
     * @param $companyId
     * @return array
     */
    public function findStatOfDate($companyId): array
    {
        return $this->createQueryBuilder('ci')
            ->select("DATE_DIFF(ci.date, '1970-01-01') AS date, SUM(ci.income) AS income")
            ->innerJoin('ci.flight', 'f')
            ->innerJoin('f.aircraft', 'a')
            ->innerJoin('a.company', 'c')
            ->where('c.id = :companyId')
            ->setParameter('companyId', $companyId)
            ->groupBy('ci.date')
            ->getQuery()
            ->getResult();
    }
}
