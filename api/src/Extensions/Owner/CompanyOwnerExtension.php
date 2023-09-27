<?php

namespace App\Extensions\Owner;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;

class CompanyOwnerExtension extends AbstractOwnerAccessExtension
{

    /**
     * @return array
     */
    public function getAffectedMethods(): array
    {
        return [
            self::GET,
            self::PUT,
            self::PATCH,
            self::DELETE
        ];
    }

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return Company::class;
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
            ->andWhere($rootAlias . '.owner = :user')
            ->setParameter('user', $binaryId);
    }

}