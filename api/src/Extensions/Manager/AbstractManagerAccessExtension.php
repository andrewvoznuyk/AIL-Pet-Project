<?php


namespace App\Extensions\Manager;

use App\Entity\User;
use App\Extensions\AbstractAccessExtension;

/**
 * Class AbstractCurrentUserExtension
 * @package App\Extension
 */
abstract class AbstractManagerAccessExtension extends AbstractAccessExtension
{

    /**
     * @return array
     */
    public function getAffectedRoles(): array
    {
        return [
            User::ROLE_MANAGER
        ];
    }

}