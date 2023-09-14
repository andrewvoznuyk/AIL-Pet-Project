<?php

namespace App\Action;

use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Security\Core\Security;

class CreateUserAction
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(User $data): User
    {
        $currentUser = $this->security->getUser();

        if (empty($currentUser)) {
            $data->setManagerAtCompany(null);
        } else {
            $roles = $currentUser->getRoles();

            if (in_array(User::ROLE_ADMIN, $roles)) {
                $data->setRoles([User::ROLE_OWNER]);
                $data->setManagerAtCompany(null);
            }
            else if (in_array(User::ROLE_OWNER, $roles)) {
                $data->setRoles([User::ROLE_MANAGER]);

                //check if company belongs to this owner
                $company = $data->getManagerAtCompany();
                if (is_null($company) || $company->getOwner() !== $currentUser) {
                    throw new UnprocessableEntityHttpException("Wrong company");
                }
            }
        }
        return $data;
    }
}