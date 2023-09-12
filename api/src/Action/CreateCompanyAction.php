<?php

namespace App\Action;

use App\Entity\Company;
use DateTime;
use Symfony\Component\Security\Core\Security;

class CreateCompanyAction
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct( Security $security )
    {
        $this->security = $security;
    }

    /**
     * @param Company $data
     * @return Company
     */
    public function __invoke( Company $data ) : Company
    {
        $user = $this->security->getUser();

        date_default_timezone_set('Europe/Kiev');
        $date = new DateTime();

        $data->setOwner($user);
        $data->setDate($date);

        return $data;
    }
}