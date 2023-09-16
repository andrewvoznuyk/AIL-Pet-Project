<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CooperationFormRepository;
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
            "normalization_context" => ["groups" => ["get:item:cooperationForm"]]
        ],
        "delete" => [
            "method"                => "DELETE",
            "normalization_context" => ["groups" => ["get:item:cooperationForm"]]
        ],
    ],
    order: ['id' => 'DESC']
)]
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
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: "cooperationFrom")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?Airport $fromAirport = null;

    /**
     * @var Airport|null
     */
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: "cooperationFrom")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:cooperationForm",
        "post:collection:cooperationForm",
        "get:item:cooperationForm"
    ])]
    private ?Airport $toAirport = null;

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
    public function getToAirport(): ?Airport
    {
        return $this->toAirport;
    }

    /**
     * @param Airport|null $toAirport
     * @return CooperationForm
     */
    public function setToAirport(?Airport $toAirport): self
    {
        $this->toAirport = $toAirport;

        return $this;
    }

    /**
     * @return Airport|null
     */
    public function getFromAirport(): ?Airport
    {
        return $this->fromAirport;
    }

    /**
     * @param Airport|null $fromAirport
     * @return $this
     */
    public function setFromAirport(?Airport $fromAirport): self
    {
        $this->fromAirport = $fromAirport;

        return $this;
    }

}
