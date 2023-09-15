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

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AircraftModel::class);
    }

}
