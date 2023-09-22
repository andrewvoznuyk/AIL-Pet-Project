<?php

namespace App\Extensions\Manager;

use App\Entity\CompanyFlights;
use App\Entity\Flight;
use App\Entity\User;
use App\Extensions\Owner\AbstractOwnerAccessExtension;
use Doctrine\ORM\QueryBuilder;

class FlightsManagerExtension extends AbstractManagerAccessExtension
{

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return Flight::class;
    }

    /**
     * @return array
     */
    public function getAffectedMethods(): array
    {
        return [
            self::GET,
            self::POST,
            self::PUT
        ];
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return void
     */
    public function buildQuery(QueryBuilder $queryBuilder): void
    {
        $rootAlias = $queryBuilder->getRootAliases()[self::FIRST_ELEMENT_ARRAY];

        /** @var User $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $binaryId = $currentUser->getId()->toBinary();

        $queryBuilder
            ->innerJoin($rootAlias.".aircraft", "plane")
            ->innerJoin("plane.company", "comp")
            ->leftJoin("comp.managers", "u")
            ->andWhere('u = :user')
            ->setParameter('user', $binaryId);
    }
}