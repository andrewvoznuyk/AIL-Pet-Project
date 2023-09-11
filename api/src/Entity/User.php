<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Ulid;

#[ApiResource()]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_USER = "ROLE_USER";
    public const ROLE_ADMIN = "ROLE_ADMIN";
    public const ROLE_OWNER = "ROLE_OWNER";
    public const ROLE_MANAGER = "ROLE_MANAGER";

    /**
     * @var string|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?string $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var string[]
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Length(min: 8, minMessage: "Password must be at least {length} characters long")]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: false)]
    #[NotBlank]
    private ?string $fullname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $phoneNumber = null;

    /**
     * @var int
     */
    #[ORM\Column]
    #[NotNull]
    private int $mileBonuses = 0;

    /**
     * @var Collection|ArrayCollection
     */
    #[ORM\OneToMany(mappedBy: 'worker', targetEntity: CompanyWorker::class)]
    private Collection $companyWorkers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ticket::class)]
    private Collection $tickets;

    /**
     * User constructor
     */
    public function __construct()
    {
        //$this->id = Uuid::v4();
        $this->roles = [self::ROLE_USER];
        $this->companyWorkers = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     * @return $this
     */
    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMileBonuses(): ?int
    {
        return $this->mileBonuses;
    }

    /**
     * @param int $mileBonuses
     * @return $this
     */
    public function setMileBonuses(int $mileBonuses): self
    {
        $this->mileBonuses = $mileBonuses;

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
     * @param CompanyWorker $companyManager
     * @return $this
     */
    public function addCompanyManager(CompanyWorker $companyManager): static
    {
        if (!$this->companyWorkers->contains($companyManager)) {
            $this->companyWorkers->add($companyManager);
            $companyManager->setWorker($this);
        }

        return $this;
    }

    /**
     * @param CompanyWorker $companyManager
     * @return $this
     */
    public function removeCompanyManager(CompanyWorker $companyManager): static
    {
        if ($this->companyWorkers->removeElement($companyManager)) {
            // set the owning side to null (unless already changed)
            if ($companyManager->getWorker() === $this) {
                $companyManager->setWorker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setUser($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getUser() === $this) {
                $ticket->setUser(null);
            }
        }

        return $this;
    }
}