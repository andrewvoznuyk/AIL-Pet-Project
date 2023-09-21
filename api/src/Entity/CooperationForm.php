<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\EntityListener\CooperationFormEntityListener;
use App\Repository\CooperationFormRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: CooperationFormRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"  => [
            "method"                => "GET",
            "security"              => "is_granted('" . User::ROLE_ADMIN . "')",
            "normalization_context" => ["groups" => ["get:collection:cooperationForm"]]
        ],
        "post" => [
            "method"                  => "POST",
            "denormalization_context" => ["groups" => ["post:collection:cooperationForm"]],
            "normalization_context"   => ["groups" => ["get:item:cooperationForm"]]
        ]
    ],
    itemOperations: [
        "get"    => [
            "method"                => "GET",
            "security"              => "is_granted('" . User::ROLE_ADMIN . "')",
            "normalization_context" => ["groups" => ["get:item:cooperationForm"]]
        ],
        "put"    => [
            "method"                => "put",
            "security"              => "is_granted('" . User::ROLE_ADMIN . "')",
            "denormalization_context" => ["groups" => ["put:item:cooperationForm"]],
            "normalization_context" => ["groups" => ["get:item:cooperationForm"]]
        ],
        "delete" => [
            "method"                => "DELETE",
            "security"              => "is_granted('" . User::ROLE_ADMIN . "')",
            "normalization_context" => ["groups" => ["get:item:cooperationForm"]]
        ],
    ],
    order: ['id' => 'DESC']
)]
#[ApiFilter(SearchFilter::class, properties: [
    "email" => "partial"
])]
#[ORM\EntityListeners([CooperationFormEntityListener::class])]
class CooperationForm
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
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?string $companyName = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?string $fullname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 180, unique: true)]
    #[Email]
    #[NotBlank]
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?string $email = null;

    /**
     * @var Airport|null
     */
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: "cooperationForm")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?Airport $airport = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?string $about = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?string $documents = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        "get:collection:cooperationForm",
        "get:item:cooperationForm",
        "put:item:cooperationForm"
    ])]
    private ?string $status = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
        "get:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?DateTimeInterface $dateOfApplication = null;

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
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return $this
     */
    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
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
     * @return string|null
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @param string $about
     * @return $this
     */
    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDocuments(): ?string
    {
        return $this->documents;
    }

    /**
     * @param string $documents
     * @return $this
     */
    public function setDocuments(string $documents): self
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @return Airport|null
     */
    public function getAirport(): ?Airport
    {
        return $this->airport;
    }

    /**
     * @param Airport|null $airport
     * @return CooperationForm
     */
    public function setAirport(?Airport $airport): self
    {
        $this->airport = $airport;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateOfApplication(): ?DateTimeInterface
    {
        return $this->dateOfApplication;
    }

    /**
     * @param DateTimeInterface|null $dateOfApplication
     * @return $this
     */
    public function setDateOfApplication(?DateTimeInterface $dateOfApplication): self
    {
        $this->dateOfApplication = $dateOfApplication;

        return $this;
    }

}
