<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource]
class Company
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyWorker::class)]
    private Collection $companyWorkers;

    /**
     *
     */
    public function __construct()
    {
        $this->companyWorkers = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, CompanyWorker>
     */
    public function getCompanyWorkers(): Collection
    {
        return $this->companyWorkers;
    }

    /**
     * @param CompanyWorker $companyWorker
     * @return $this
     */
    public function addCompanyWorker(CompanyWorker $companyWorker): self
    {
        if (!$this->companyWorkers->contains($companyWorker)) {
            $this->companyWorkers->add($companyWorker);
            $companyWorker->setCompany($this);
        }

        return $this;
    }

    /**
     * @param CompanyWorker $companyWorker
     * @return $this
     */
    public function removeCompanyWorker(CompanyWorker $companyWorker): self
    {
        if ($this->companyWorkers->removeElement($companyWorker)) {
            // set the owning side to null (unless already changed)
            if ($companyWorker->getCompany() === $this) {
                $companyWorker->setCompany(null);
            }
        }

        return $this;
    }
}
