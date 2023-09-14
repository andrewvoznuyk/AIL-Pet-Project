<?php

namespace App\Entity;

use App\Repository\CompanyIncomeRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CompanyIncomeRepository::class)]
class CompanyIncome
{
    /**
     * @var Uuid
     */
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    private Uuid $id;

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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @return Uuid|null
     */
    public function getId(): ?Uuid
    {
        return $this->id;
    }

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

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
