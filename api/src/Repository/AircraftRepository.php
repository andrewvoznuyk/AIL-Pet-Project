<?php

namespace App\Repository;

use App\Entity\Aircraft;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aircraft>
 *
 * @method Aircraft|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aircraft|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aircraft[]    findAll()
 * @method Aircraft[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AircraftRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aircraft::class);
    }

}
