<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Action\CancelFlightAction;
use App\Action\FinishFlightAction;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\EntityListener\FlightEntityListener;
use App\Repository\FlightRepository;
use App\Validator\Constraints\FlightConstraint;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JsonSerializable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"  => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:collection:flight"]]
        ],
        "post" => [
            "method"                  => "POST",
            "security"                => "is_granted('" . User::ROLE_MANAGER . "')",
            "denormalization_context" => ["groups" => ["post:collection:flight"]],
            "normalization_context"   => ["groups" => ["get:item:flight"]]
        ]
    ],
    itemOperations: [
        "get" => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:item:flight"]]
        ],
        "finish" => [
            "method"                  => "PUT",
            "path"                    => "/flight/{id}/finish",
            "security"                => "is_granted('" . User::ROLE_MANAGER . "') && object.getAircraft().getCompany() == user.getManagerAtCompany()",
            "denormalization_context" => ["groups" => ["flight:empty"]],
            "normalization_context"   => ["groups" => ["finish:item:flight"]],
            "controller" => FinishFlightAction::class
        ],
        "cancel" => [
            "method"                  => "PUT",
            "path"                    => "/flight/{id}/cancel",
            "security"                => "is_granted('" . User::ROLE_MANAGER . "') && object.getAircraft().getCompany() == user.getManagerAtCompany()",
            "denormalization_context" => ["groups" => ["flight:empty"]],
            "normalization_context"   => ["groups" => ["finish:item:flight"]],
            "controller" => CancelFlightAction::class
        ]
    ],
    attributes: [
        "security" => "is_granted('" . User::ROLE_ADMIN . "') or is_granted('" . User::ROLE_USER . "') or is_granted('" . User::ROLE_MANAGER . "') or is_granted('" . User::ROLE_OWNER . "')"
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    "fromLocation" => "partial",
    "toLocation" => "partial",
])]
#[FlightConstraint]
#[ORM\EntityListeners([FlightEntityListener::class])]
class Flight implements JsonSerializable
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:item:flight",
        "get:collection:flight"
    ])]
    private ?int $id = null;

    /**
     * @var Aircraft|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:collection:flight"
    ])]
    private ?Aircraft $aircraft = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:collection:flight"
    ])]
    private ?DateTimeInterface $departure = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:item:flight",
        "post:collection:flight"
    ])]
    private ?DateTimeInterface $arrival = null;

    /**
     * @var bool|null
     */
    #[ORM\Column]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:collection:flight",
        "finish:item:flight"
    ])]
    private bool $isCompleted = false;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Ticket::class)]
    private Collection $tickets;

    /**
     * @var CompanyFlights|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:collection:flight"
    ])]
    private ?CompanyFlights $fromLocation = null;

    /**
     * @var CompanyFlights|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:collection:flight"
    ])]
    private ?CompanyFlights $toLocation = null;

    /**
     * @var array
     */
    #[ORM\Column]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:collection:flight"
    ])]
    private array $placesCoefs = [];

    /**
     * @var array
     */
    #[ORM\Column]
    #[Groups([
        "get:item:flight",
        "get:collection:flight",
        "post:collection:flight"
    ])]
    private array $initPrices = [];

    /**
     * @var string
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 30, scale: 2)]
    private string $distance;


    /**
     *
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();

        $this->isCompleted = false;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Aircraft|null
     */
    public function getAircraft(): ?Aircraft
    {
        return $this->aircraft;
    }

    /**
     * @param Aircraft|null $aircraft
     * @return $this
     */
    public function setAircraft(?Aircraft $aircraft): self
    {
        $this->aircraft = $aircraft;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeparture(): ?DateTimeInterface
    {
        return $this->departure;
    }

    /**
     * @param DateTimeInterface $departure
     * @return $this
     */
    public function setDeparture(DateTimeInterface $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getArrival(): ?DateTimeInterface
    {
        return $this->arrival;
    }

    /**
     * @param DateTimeInterface $arrival
     * @return $this
     */
    public function setArrival(DateTimeInterface $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     * @return $this
     */
    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    /**
     * @param Ticket $ticket
     * @return $this
     */
    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setFlight($this);
        }

        return $this;
    }

    /**
     * @param Ticket $ticket
     * @return $this
     */
    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getFlight() === $this) {
                $ticket->setFlight(null);
            }
        }

        return $this;
    }

    /**
     * @return CompanyFlights|null
     */
    public function getFromLocation(): ?CompanyFlights
    {
        return $this->fromLocation;
    }

    /**
     * @param CompanyFlights|null $fromLocation
     * @return $this
     */
    public function setFromLocation(?CompanyFlights $fromLocation): self
    {
        $this->fromLocation = $fromLocation;

        return $this;
    }

    /**
     * @return CompanyFlights|null
     */
    public function getToLocation(): ?CompanyFlights
    {
        return $this->toLocation;
    }

    /**
     * @param CompanyFlights|null $toLocation
     * @return $this
     */
    public function setToLocation(?CompanyFlights $toLocation): self
    {
        $this->toLocation = $toLocation;

        return $this;
    }

    /**
     * @return array
     */
    public function getPlacesCoefs(): array
    {
        return $this->placesCoefs;
    }

    /**
     * @param array $placesCoefs
     * @return $this
     */
    public function setPlacesCoefs(array $placesCoefs): self
    {
        $this->placesCoefs = $placesCoefs;

        return $this;
    }

    /**
     * @return array
     */
    public function getInitPrices(): array
    {
        return $this->initPrices;
    }

    /**
     * @param array $initPrices
     * @return $this
     */
    public function setInitPrices(array $initPrices): self
    {
        $this->initPrices = $initPrices;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistance(): ?string
    {
        return $this->distance;
    }

    /**
     * @return $this
     */
    public function setDistance(string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "company"=>$this->getFromLocation()->getCompany()->getName(),
            "fromLocation" => [
                "fromId" => $this->getFromLocation()->getAirport()->getId(),
                "name" => $this->getFromLocation()->getAirport()->getName(),
                "city"=>$this->getFromLocation()->getAirport()->getCity(),
            ],
            "toLocation" => [
                "toId" => $this->getToLocation()->getAirport()->getId(),
                "name" => $this->getToLocation()->getAirport()->getName(),
                "city"=>$this->getToLocation()->getAirport()->getCity()
            ],
            "distance" => $this->getDistance(),
            "aircraftNumber"=>$this->getAircraft()->getSerialNumber(),
            "aircraftModel"=>$this->getAircraft()->getModel()->getPlane()
        ];
    }

}