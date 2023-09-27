<?php

namespace App\Extensions\Owner;

use App\Entity\CompanyFlights;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;

class CompanyFlightsOwnerExtension extends AbstractOwnerAccessExtension
{

    /**
     * @return array
     */
    public function getAffectedMethods(): array
    {
        return [
            self::GET,
            self::PUT,
        ];
    }

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return CompanyFlights::class;
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
            ->innerJoin($rootAlias . ".company", "oCompany")
            ->andWhere('oCompany.owner = :user')
            ->andWhere($rootAlias . '.isDeleted = false')
            ->setParameter('user', $binaryId);
    }

}