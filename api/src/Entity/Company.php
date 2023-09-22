<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\EntityListener\CompanyEntityListener;
use App\Repository\CompanyRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"  => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:collection:company"]]
        ],
        "post" => [
            "method"                  => "POST",
            "security"                => "is_granted('" . User::ROLE_OWNER . "')",
            "denormalization_context" => ["groups" => ["post:collection:company"]],
            "normalization_context"   => ["groups" => ["get:item:company"]]
        ]
    ],
    itemOperations: [
        "get"    => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:item:company"]]
        ],
        "put"    => [
            "method"                  => "PUT",
            "security"                => "is_granted('" . User::ROLE_OWNER . "')",
            "denormalization_context" => ["groups" => ["post:collection:company"]],
            "normalization_context"   => ["groups" => ["get:item:company"]]
        ],
        "patch"  => [
            "method"                  => "PATCH",
            "security"                => "is_granted('" . User::ROLE_OWNER . "')",
            "denormalization_context" => ["groups" => ["post:collection:company"]],
            "normalization_context"   => ["groups" => ["get:item:company"]]
        ],
        "delete" => [
            "method"                => "DELETE",
            "security"              => "is_granted('" . User::ROLE_OWNER . "')",
            "normalization_context" => ["groups" => ["get:item:company"]]
        ],
    ],
    order: ['id' => 'DESC']
)]
#[ORM\EntityListeners([CompanyEntityListener::class])]
class Company
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:collection:company",
        "get:collection:companyFlights",
        "get:collection:user",
        "get:item:companyFlights",
        "get:item:user"
    ])]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[NotNull]
    #[Groups([
        "get:collection:company",
        "post:collection:company",
        "get:item:company",
        "get:collection:companyFlights",
    ])]
    private ?string $name = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Aircraft::class, orphanRemoval: true)]
    private Collection $aircrafts;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Rating::class)]
    private Collection $ratings;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups([
        "get:collection:company",
        "get:item:company"
    ])]
    private ?DateTimeInterface $date = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'managerAtCompany', targetEntity: User::class)]
    private Collection $managers;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyFlights::class)]
    private Collection $companyFlights;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'companies')]
    private ?User $owner = null;

    /**
     * Company controller
     */
    public function __construct()
    {
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
     * @return DateTimeInterface|null
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     * @return $this
     */
    public function setDate(DateTimeInterface $date): self
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
