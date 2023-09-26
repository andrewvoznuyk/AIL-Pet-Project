<?php

namespace App\Action;

use App\Entity\DeletableEntity;

class DeleteDeletableAction
{

    /**
     * @param DeletableEntity $data
     * @return DeletableEntity
     */
    public function __invoke(DeletableEntity $data): DeletableEntity
    {
        $data->setIsDeleted(true);

        return $data;
    }

}