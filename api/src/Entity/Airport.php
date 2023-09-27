<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Action\GetAirportApiAction;
use App\Repository\AirportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Services\GetApiDataService;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
#[\App\Validator\Constraints\Airport]
#[ApiResource(
    collectionOperations: [
        "get"  => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:collection:airport"]]
        ],
        "post" => [
            "method"                  => "POST",
            "security"                => "is_granted('" . User::ROLE_ADMIN . "')",
            "denormalization_context" => ["groups" => ["post:collection:airport"]],
            "normalization_context"   => ["groups" => ["get:item:airport"]],
            "controller"              => GetAirportApiAction::class
        ]
    ],
    itemOperations: [
        "get" => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:item:airport"]]
        ]
    ],
    attributes: [
        "security" => "is_granted('" . User::ROLE_ADMIN . "') or is_granted('" . User::ROLE_USER . "') or is_granted('" . User::ROLE_MANAGER . "') or is_granted('" . User::ROLE_OWNER . "')"
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    "name"    => "partial",
    "city"    => "partial",
    "country" => "partial",
])]
class Airport
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:collection:airport"
    ])]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[Groups([
        "get:item:airport",
        "get:collection:airport",
        "get:item:flight",
        "get:collection:flight",
        "get:collection:companyFlights",
        "get:item:companyFlights",
        "get:collection:companyFlights"
    ])]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:airport",
        "get:collection:airport",
        "get:item:flight",
        "get:collection:flight",
        "get:item:companyFlights",
        "get:collection:companyFlights"
    ])]
    private ?string $city = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[Groups([
        "get:item:airport",
        "get:collection:airport",
        "get:item:flight",
        "get:collection:flight",
        "get:item:companyFlights",
        "get:collection:companyFlights"
    ])]
    private ?string $country = null;

    /**
     * @var float|null
     */
    #[ORM\Column(nullable: true)]
    private ?float $lon = null;

    /**
     * @var float|null
     */
    #[ORM\Column(nullable: true)]
    private ?float $lat = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: "airport", targetEntity: CooperationForm::class)]
    private Collection $cooperationForm;

    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $offset = null;

    /**
     * Airport constructor
     */
    public function __construct()
    {
        $this->cooperationForm = new ArrayCollection();
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
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return array
     */
    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @param array $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLon(): ?float
    {
        return $this->lon;
    }

    /**
     * @param float|null $lon
     * @return $this
     */
    public function setLon(?float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     * @return $this
     */
    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCooperationForm(): Collection
    {
        return $this->cooperationForm;
    }

    /**
     * @param Collection $cooperationForm
     * @return $this
     */
    public function setCooperationForm(Collection $cooperationForm): self
    {
        $this->cooperationForm = $cooperationForm;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     * @return $this
     */
    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

}
