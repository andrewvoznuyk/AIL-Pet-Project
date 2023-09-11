<?php

namespace App\Entity;

use App\Repository\CompanyFlightsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyFlightsRepository::class)]
class CompanyFlights
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Company|null
     */
    #[ORM\ManyToOne(inversedBy: 'companyFlights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'fromLocation', targetEntity: Flight::class)]
    private Collection $flights;

    /**
     *
     */
    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Flight>
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    /**
     * @param Flight $flight
     * @return $this
     */
    public function addFlight(Flight $flight): static
    {
        if (!$this->flights->contains($flight)) {
            $this->flights->add($flight);
            $flight->setFromLocation($this);
        }

        return $this;
    }

    /**
     * @param Flight $flight
     * @return $this
     */
    public function removeFlight(Flight $flight): static
    {
        if ($this->flights->removeElement($flight)) {
            // set the owning side to null (unless already changed)
            if ($flight->getFromLocation() === $this) {
                $flight->setFromLocation(null);
            }
        }

        return $this;
    }
}
