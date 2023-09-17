<?php


namespace App\Extensions\Owner;

use App\Entity\User;
use App\Extensions\AbstractAccessExtension;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Class AbstractCurrentUserExtension
 * @package App\Extension
 */
abstract class AbstractOwnerAccessExtension extends AbstractAccessExtension
{

    public function getAffectedRoles(): array
    {
        return [
            User::ROLE_OWNER
        ];
    }
}