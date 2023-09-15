<?php

namespace App\EntityListener;

use App\Entity\Company;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class CompanyEntityListener
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

    /**
     * @param Company $company
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(Company $company, LifecycleEventArgs $eventArgs): void
    {
        /** @var User $currentUser */
        $user = $this->security->getUser();

        date_default_timezone_set('Europe/Kiev');
        $date = new DateTime();

        $company->setOwner($user);
        $company->setDate($date);
    }

}