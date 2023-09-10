<?php

namespace App\Entity;

use App\Repository\CompanyManagerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyManagerRepository::class)]
class CompanyWorker
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'companyManagers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $worker = null;

    /**
     * @var Company|null
     */
    #[ORM\ManyToOne(inversedBy: 'companyWorkers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getWorker(): ?User
    {
        return $this->worker;
    }

    /**
     * @param User|null $worker
     * @return $this
     */
    public function setWorker(?User $worker): self
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     * @return $this
     */
    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
