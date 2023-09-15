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

}
