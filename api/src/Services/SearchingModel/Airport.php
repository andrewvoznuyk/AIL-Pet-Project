<?php

namespace App\Services\SearchingModel;

class Airport
{

    /**
     * @var string
     */
    private string $item;
    /**
     * @var Airport|null
     */
    private ?Airport $next;

    /**
     * @param string $item
     * @param Airport|null $next
     */
    public function __construct(string $item, ?Airport $next = null)
    {
        $this->item = $item;
        $this->next = $next;
    }

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