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

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteIncome::class);
    }

    /**
     * @return array
     */
    public function findStatOfDateAdmin(): array
    {

        return $this->createQueryBuilder('wi')
            ->select("DATE_DIFF(ci.date, '1970-01-01') AS date, SUM(wi.income) AS income")
            ->innerJoin('wi.companyIncome', 'ci')
            ->groupBy('ci.date')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     */
    public function findStatOfCompanyAdmin(): array
    {

        return $this->createQueryBuilder('wi')
            ->select('c.name AS company, SUM(wi.income) AS income')
            ->innerJoin('wi.companyIncome', 'ci')
            ->innerJoin('ci.flight', 'f')
            ->innerJoin('f.aircraft', 'a')
            ->innerJoin('a.company', 'c')
            ->groupBy('c.name')
            ->getQuery()
            ->getResult();
    }
}
