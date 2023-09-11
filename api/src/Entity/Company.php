<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Aircraft::class, orphanRemoval: true)]
    private Collection $aircrafts;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Rating::class)]
    private Collection $ratings;

    /**
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'managerAtCompany', targetEntity: User::class)]
    private Collection $managers;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyFlights::class)]
    private Collection $companyFlights;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     *
     */
    public function __construct()
    {
        $this->companyWorkers = new ArrayCollection();
        $this->aircrafts = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->managers = new ArrayCollection();
        $this->companyFlights = new ArrayCollection();
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
     * @return Collection<int, Aircraft>
     */
    public function getAircrafts(): Collection
    {
        return $this->aircrafts;
    }

    /**
     * @param Aircraft $aircraft
     * @return $this
     */
    public function addAircraft(Aircraft $aircraft): self
    {
        if (!$this->aircrafts->contains($aircraft)) {
            $this->aircrafts->add($aircraft);
            $aircraft->setCompany($this);
        }

        return $this;
    }

    /**
     * @param Aircraft $aircraft
     * @return $this
     */
    public function removeAircraft(Aircraft $aircraft): self
    {
        if ($this->aircrafts->removeElement($aircraft)) {
            // set the owning side to null (unless already changed)
            if ($aircraft->getCompany() === $this) {
                $aircraft->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    /**
     * @param Rating $rating
     * @return $this
     */
    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setCompany($this);
        }

        return $this;
    }

    /**
     * @param Rating $rating
     * @return $this
     */
    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getCompany() === $this) {
                $rating->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return $this
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    /**
     * @param User $manager
     * @return $this
     */
    public function addManager(User $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers->add($manager);
            $manager->setManagerAtCompany($this);
        }

        return $this;
    }

    /**
     * @param User $manager
     * @return $this
     */
    public function removeManager(User $manager): self
    {
        if ($this->managers->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getManagerAtCompany() === $this) {
                $manager->setManagerAtCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyFlights>
     */
    public function getCompanyFlights(): Collection
    {
        return $this->companyFlights;
    }

    /**
     * @param CompanyFlights $companyFlight
     * @return $this
     */
    public function addCompanyFlight(CompanyFlights $companyFlight): self
    {
        if (!$this->companyFlights->contains($companyFlight)) {
            $this->companyFlights->add($companyFlight);
            $companyFlight->setCompany($this);
        }

        return $this;
    }

    /**
     * @param CompanyFlights $companyFlight
     * @return $this
     */
    public function removeCompanyFlight(CompanyFlights $companyFlight): self
    {
        if ($this->companyFlights->removeElement($companyFlight)) {
            // set the owning side to null (unless already changed)
            if ($companyFlight->getCompany() === $this) {
                $companyFlight->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     * @return $this
     */
    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
