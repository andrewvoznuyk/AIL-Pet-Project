<?php


namespace App\Extensions\Manager;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\User;
use App\Extensions\AbstractAccessExtension;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Class AbstractCurrentUserExtension
 * @package App\Extension
 */
abstract class AbstractManagerAccessExtension extends AbstractAccessExtension
{
    public function getAffectedRoles(): array
    {
        return [
            User::ROLE_MANAGER
        ];
    }

    public function getAffectedMethods(): array
    {
        return [
            self::GET
        ];
    }

}