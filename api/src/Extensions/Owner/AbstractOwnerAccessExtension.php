<?php


namespace App\Extensions\Owner;

use App\Entity\User;
use App\Extensions\AbstractAccessExtension;

/**
 * Class AbstractCurrentUserExtension
 * @package App\Extension
 */
abstract class AbstractOwnerAccessExtension extends AbstractAccessExtension
{

    /**
     * @return array
     */
    public function getAffectedRoles(): array
    {
        return [
            User::ROLE_OWNER
        ];
    }

}