<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
#[ApiResource]
class Flight
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Aircraft|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aircraft $aircraft = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $departure = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrival = null;

    /**
     * @var bool|null
     */
    #[ORM\Column]
    private ?bool $isCompleted = null;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Ticket::class)]
    private Collection $tickets;


    /**
     *
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
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
    public function setAircraft(?Aircraft $aircraft): static
    {
        $this->aircraft = $aircraft;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    /**
     * @param \DateTimeInterface $departure
     * @return $this
     */
    public function setDeparture(\DateTimeInterface $departure): static
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getArrival(): ?\DateTimeInterface
    {
        return $this->arrival;
    }

    /**
     * @param \DateTimeInterface $arrival
     * @return $this
     */
    public function setArrival(\DateTimeInterface $arrival): static
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     * @return $this
     */
    public function setIsCompleted(bool $isCompleted): static
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
    public function addTicket(Ticket $ticket): static
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
    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getFlight() === $this) {
                $ticket->setFlight(null);
            }
        }

        return $this;
    }
}
