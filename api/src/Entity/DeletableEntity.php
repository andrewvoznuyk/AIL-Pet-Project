<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class DeletableEntity
{
    /**
     * @var bool
     */
    #[ORM\Column]
    protected bool $isDeleted = false;

    /**
     * @return bool
     */
    public function isIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     * @return $this
     */
    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

}