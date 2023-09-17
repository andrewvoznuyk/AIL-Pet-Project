<?php

namespace App\EntityListener;

use App\Entity\CooperationForm;
use DateTime;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class CooperationFormEntityListener
{

    /**
     * @param CooperationForm $cooperationForm
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(CooperationForm $cooperationForm, LifecycleEventArgs $eventArgs): void
    {
        date_default_timezone_set('Europe/Kiev');
        $date = new DateTime();

        $status = "new";

        $cooperationForm->setStatus($status);
        $cooperationForm->setDateOfApplication($date);
    }

}