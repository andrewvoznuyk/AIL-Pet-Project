<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Action\CancelFlightAction;
use App\Action\FinishFlightAction;
use App\EntityListener\TicketEntityListener;
use App\Repository\TicketRepository;
use App\Validator\Constraints\TicketConstraint;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "method"                => "GET",
            "security"              => "is_granted('" . User::ROLE_USER . "')",
            "normalization_context" => ["groups" => ["get:collection:ticket"]]
        ]
    ],
    itemOperations: [
        "get" => [
            "method"                => "GET",
            "security"              => "is_granted('" . User::ROLE_USER . "')",
            "normalization_context" => ["groups" => ["get:item:ticket"]]
        ]
    ],
    order: ['flight.departure' => 'ASC']
)]
#[GroupSequence([
    "Ticket",
    "constraint:last"
])]
#[TicketConstraint(groups: ["constraint:last"])]
#[ORM\EntityListeners([TicketEntityListener::class])]
class Ticket
{

    public const SKIPPED_PLACES = [13];

    /**
     * @var Uuid
     */
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    private Uuid $id;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[NotBlank]
    private ?User $user = null;

    /**
     * @var Flight|null
     */
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[NotBlank]
    #[Groups([
        "get:collection:ticket",
        "get:item:ticket"
    ])]
    private ?Flight $flight = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    #[Groups([
        "get:collection:ticket",
        "get:item:ticket"
    ])]
    #[NotBlank]
    private ?int $place = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:collection:ticket",
        "get:item:ticket"
    ])]
    #[NotBlank]
    private ?string $class = null;

    /**
     * @var float|null
     */
    #[ORM\Column(type: "float")]
    #[NotBlank]
    #[GreaterThan(0)]
    #[Groups([
        "get:item:ticket"
    ])]
    private ?float $price = 0;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[Groups([
        "get:item:ticket",
        "get:collection:ticket",
    ])]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[Groups([
        "get:item:ticket",
        "get:collection:ticket",
    ])]
    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $documentId = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[NotBlank]
    private ?DateTimeInterface $birthDate = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    #[NotBlank]
    #[GreaterThanOrEqual(0)]
    #[Groups([
        "get:item:ticket"
    ])]
    private ?int $luggageMass = 0;

    /**
     * @return Uuid|null
     */
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Flight|null
     */
    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    /**
     * @param Flight|null $flight
     * @return $this
     */
    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPlace(): ?int
    {
        return $this->place;
    }

    /**
     * @param int $place
     * @return $this
     */
    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param int|float $price
     * @return $this
     */
    public function setPrice(int|float $price): self
    {
        $this->price = floatval($price);

        return $this;
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
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }

    /**
     * @param string $documentId
     * @return $this
     */
    public function setDocumentId(string $documentId): self
    {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param DateTimeInterface $birthDate
     * @return $this
     */
    public function setBirthDate(DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLuggageMass(): ?int
    {
        return $this->luggageMass;
    }

    /**
     * @param int $luggageMass
     * @return $this
     */
    public function setLuggageMass(int $luggageMass): self
    {
        $this->luggageMass = $luggageMass;

        return $this;
    }

}
