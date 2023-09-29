<?php

namespace App\Extensions\Owner;

use App\Entity\Aircraft;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;

class AircraftOwnerExtension extends AbstractOwnerAccessExtension
{

    /**
     * @return array
     */
    public function getAffectedMethods(): array
    {
        return [
            self::GET,
            self::PUT,
            self::PATCH
        ];
    }

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return Aircraft::class;
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
            ->innerJoin($rootAlias . ".company", "planeCompany")
            ->andWhere('planeCompany.owner = :user')
            ->andWhere($rootAlias . '.isDeleted = false')
            ->setParameter('user', $binaryId);
    }

}