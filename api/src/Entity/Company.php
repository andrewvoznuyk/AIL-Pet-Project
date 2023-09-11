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
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Aircraft::class, orphanRemoval: true)]
    private Collection $aircrafts;

    /**
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'managerOfCompany', targetEntity: User::class)]
    private Collection $managers;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Rating::class, orphanRemoval: true)]
    private Collection $ratingsArray;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyFlights::class)]
    private Collection $companyFlights;

    /**
     *
     */
    public function __construct()
    {
        $this->aircrafts = new ArrayCollection();
        $this->managers = new ArrayCollection();
        $this->ratingsArray = new ArrayCollection();
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
            $manager->setManagerOfCompany($this);
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
            if ($manager->getManagerOfCompany() === $this) {
                $manager->setManagerOfCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatingsArray(): Collection
    {
        return $this->ratingsArray;
    }

    /**
     * @param Rating $ratingsArray
     * @return $this
     */
    public function addRatingsArray(Rating $ratingsArray): self
    {
        if (!$this->ratingsArray->contains($ratingsArray)) {
            $this->ratingsArray->add($ratingsArray);
            $ratingsArray->setCompany($this);
        }

        return $this;
    }

    /**
     * @param Rating $ratingsArray
     * @return $this
     */
    public function removeRatingsArray(Rating $ratingsArray): self
    {
        if ($this->ratingsArray->removeElement($ratingsArray)) {
            // set the owning side to null (unless already changed)
            if ($ratingsArray->getCompany() === $this) {
                $ratingsArray->setCompany(null);
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

    public function addCompanyFlight(CompanyFlights $companyFlight): static
    {
        if (!$this->companyFlights->contains($companyFlight)) {
            $this->companyFlights->add($companyFlight);
            $companyFlight->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyFlight(CompanyFlights $companyFlight): static
    {
        if ($this->companyFlights->removeElement($companyFlight)) {
            // set the owning side to null (unless already changed)
            if ($companyFlight->getCompany() === $this) {
                $companyFlight->setCompany(null);
            }
        }

        return $this;
    }
}
