<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Action\CreateUserAction;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ApiResource(
    collectionOperations: [
        "get"  => [
            "method"                => "GET",
            "security"              => "is_granted('" . User::ROLE_ADMIN . "') or is_granted('" . User::ROLE_OWNER . "')",
            "normalization_context" => ["groups" => ["get:collection:user"]]
        ],
        "post" => [
            "method"                  => "POST",
            "security"                => "!is_granted('" . User::ROLE_MANAGER . "') and !is_granted('" . User::ROLE_USER . "')",
            "denormalization_context" => ["groups" => ["post:collection:user"]],
            "normalization_context"   => ["groups" => ["empty"]],
            "controller"              => CreateUserAction::class
        ]
    ],
    itemOperations: [
        "get" => [
            "method"                => "GET",
            "security"              => "(is_granted('" . User::ROLE_ADMIN . "')) or (is_granted('" . User::ROLE_USER . "') and object == user)",
            "normalization_context" => ["groups" => ["get:item:user"]]
        ],
        "put" => [
            "method"                  => "PUT",
            "security"                => "object == user",
            "denormalization_context" => ["groups" => ["put:item:user"]],
            "normalization_context"   => ["groups" => ["get:item:user"]]
        ]
    ]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ["email"], message: "Email is already in use")]
#[UniqueEntity(fields: ["phoneNumber"], message: "Phone number is already in use")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    public const ROLE_USER    = "ROLE_USER";
    public const ROLE_ADMIN   = "ROLE_ADMIN";
    public const ROLE_OWNER   = "ROLE_OWNER";
    public const ROLE_MANAGER = "ROLE_MANAGER";

    /**
     * @var Uuid
     */
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    #[Groups([
        "get:collection:user"
    ])]
    private Uuid $id;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 180, unique: true)]
    #[Email]
    #[NotBlank]
    #[Groups([
        "get:item:user",
        "get:collection:user",
        "post:collection:user"
    ])]
    private ?string $email = null;

    /**
     * @var string[]
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    #[Length(min: 8, minMessage: "Password must be at least {{ limit }} characters long")]
    #[Groups([
        "post:collection:user"
    ])]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, unique: true)]
    #[NotBlank]
    #[Groups([
        "get:item:user",
        "get:collection:user",
        "put:item:user",
        "post:collection:user"
    ])]
    private ?string $phoneNumber = null;

    /**
     * @var int
     */
    #[ORM\Column]
    #[NotNull]
    private int $mileBonuses = 0;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ticket::class)]
    private Collection $tickets;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:user",
        "get:collection:user",
        "put:item:user",
        "post:collection:user"
    ])]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:user",
        "get:collection:user",
        "put:item:user",
        "post:collection:user"
    ])]
    private ?string $surname = null;

    /**
     * @var Company|null
     */
    #[ORM\ManyToOne(inversedBy: 'managers')]
    #[Groups([
        "post:collection:user"
    ])]
    private ?Company $managerAtCompany = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Company::class)]
    #[Groups([
        "post:collection:user"
    ])]
    private Collection $companies;

    /**
     * @var Verification|null
     */
    #[ORM\OneToOne(mappedBy: 'user', cascade: [
        'persist',
        'remove'
    ])]
    private ?Verification $verification = null;

    /**
     * @var bool
     */
    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * User constructor
     */
    public function __construct()
    {
        $this->roles = [self::ROLE_USER];
        $this->tickets = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    /**
     * @return Uuid|null
     */
    public function getId(): ?Uuid
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
            $ticket->setUser($this);
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
            if ($ticket->getUser() === $this) {
                $ticket->setUser(null);
            }
        }

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
     * @return Company|null
     */
    public function getManagerAtCompany(): ?Company
    {
        return $this->managerAtCompany;
    }

    /**
     * @param Company|null $managerAtCompany
     * @return $this
     */
    public function setManagerAtCompany(?Company $managerAtCompany): self
    {
        $this->managerAtCompany = $managerAtCompany;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    /**
     * @param Company $company
     * @return $this
     */
    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->setOwner($this);
        }

        return $this;
    }

    /**
     * @param Company $company
     * @return $this
     */
    public function removeCompany(Company $company): self
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getOwner() === $this) {
                $company->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Verification|null
     */
    public function getVerification(): ?Verification
    {
        return $this->verification;
    }

    /**
     * @param Verification $verification
     * @return $this
     */
    public function setVerification(Verification $verification): self
    {
        // set the owning side of the relation if necessary
        if ($verification->getUser() !== $this) {
            $verification->setUser($this);
        }

        $this->verification = $verification;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @param bool $isVerified
     * @return $this
     */
    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

}