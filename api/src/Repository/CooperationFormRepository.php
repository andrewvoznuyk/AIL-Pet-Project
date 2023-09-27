<?php

namespace App\Repository;

use App\Entity\CooperationForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CooperationForm>
 *
 * @method CooperationForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method CooperationForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method CooperationForm[]    findAll()
 * @method CooperationForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CooperationFormRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CooperationForm::class);
    }

}
