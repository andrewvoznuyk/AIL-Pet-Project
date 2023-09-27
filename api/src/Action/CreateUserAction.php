<?php

namespace App\Action;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class CreateUserAction
{

    /**
     * @param Security $security
     * @param UserPasswordHasherInterface $passwordHasher
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private Security                    $security,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface          $validator,
    ){}

    public function __invoke(User $data): User
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        //if unauthorized
        if (empty($currentUser)) {
            $data->setManagerAtCompany(null);
        } else {
            $roles = $currentUser->getRoles();

            //Admin creates owner
            if (in_array(User::ROLE_ADMIN, $roles)) {
                $data->setRoles([User::ROLE_OWNER]);
                $data->setManagerAtCompany(null);
            } //Owner creates manager
            else if (in_array(User::ROLE_OWNER, $roles)) {
                $data->setRoles([User::ROLE_MANAGER]);

                //check if company belongs to this owner
                $company = $data->getManagerAtCompany();

                if (is_null($company) || $company->getOwner() !== $currentUser) {
                    throw new UnprocessableEntityHttpException("Wrong company");
                }
            }
        }

        $this->validator->validate($data);

        //hash password
        $hashedPassword = $this->passwordHasher->hashPassword($data, $data->getPassword());
        $data->setPassword($hashedPassword);

        return $data;
    }

}