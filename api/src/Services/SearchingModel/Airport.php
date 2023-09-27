<?php

namespace App\Services\SearchingModel;

class Airport
{

    /**
     * @param string $item
     * @param Airport|null $next
     */
    public function __construct(private string $item, private ?Airport $next = null){}

    /**
     * @return string
     */
    public function getItem(): string
    {
        return $this->item;
    }

    /**
     * @return Airport|null
     */
    public function getNext(): ?Airport
    {
        return $this->next;
    }

    /**
     * @param Airport|null $next
     */
    public function setNext(?Airport $next): void
    {
        $this->next = $next;
    }

}