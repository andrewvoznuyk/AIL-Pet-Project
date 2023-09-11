<?php

namespace App\Entity;

use App\Repository\CompanyIncomeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyIncomeRepository::class)]
class CompanyIncome
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Flight|null
     */
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Flight $flight = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $income = null;

    /**
     * @return Flight|null
     */
    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    /**
     * @param Flight $flight
     * @return $this
     */
    public function setFlight(Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIncome(): ?int
    {
        return $this->income;
    }

    /**
     * @param int $income
     * @return $this
     */
    public function setIncome(int $income): self
    {
        $this->income = $income;

        return $this;
    }
}
