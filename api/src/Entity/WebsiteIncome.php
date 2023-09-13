<?php

namespace App\Entity;

use App\Repository\WebsiteIncomeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteIncomeRepository::class)]
class WebsiteIncome
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var CompanyIncome|null
     */
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyIncome $companyIncome = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $income = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return CompanyIncome|null
     */
    public function getCompanyIncome(): ?CompanyIncome
    {
        return $this->companyIncome;
    }

    /**
     * @param CompanyIncome $companyIncome
     * @return $this
     */
    public function setCompanyIncome(CompanyIncome $companyIncome): self
    {
        $this->companyIncome = $companyIncome;

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
