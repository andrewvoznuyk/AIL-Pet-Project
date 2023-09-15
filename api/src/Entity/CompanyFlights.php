<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompanyFlightsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyFlightsRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"  => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:collection:companyFlights"]]
        ],
        "post" => [
            "method"                  => "POST",
            "security"                => "is_granted('" . User::ROLE_OWNER . "')",
            "denormalization_context" => ["groups" => ["post:collection:companyFlights"]],
            "normalization_context"   => ["groups" => ["get:item:companyFlights"]]
        ]
    ],
    itemOperations: [
        "get"    => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:item:companyFlights"]]
        ],
        "put"    => [
            "method"                  => "PUT",
            "security"                => "is_granted('" . User::ROLE_OWNER . "')",
            "denormalization_context" => ["groups" => ["post:collection:companyFlights"]],
            "normalization_context"   => ["groups" => ["get:item:companyFlights"]]
        ],
        "patch"  => [
            "method"                  => "PATCH",
            "security"                => "is_granted('" . User::ROLE_OWNER . "')",
            "denormalization_context" => ["groups" => ["post:collection:companyFlights"]],
            "normalization_context"   => ["groups" => ["get:item:companyFlights"]]
        ],
        "delete" => [
            "method"                => "DELETE",
            "security"              => "is_granted('" . User::ROLE_OWNER . "')",
            "normalization_context" => ["groups" => ["get:item:companyFlights"]]
        ],
    ],
    order: ['id' => 'DESC']
)]
class CompanyFlights
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Airport|null
     */
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: "companyFlights")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:companyFlights",
        "post:collection:companyFlights",
        "get:item:companyFlights"
    ])]
    private ?Airport $fromAirport = null;

    /**
     * @var Airport|null
     */
    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy: "companyFlights")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:companyFlights",
        "post:collection:companyFlights",
        "get:item:companyFlights"
    ])]
    private ?Airport $toAirport = null;

    /**
     * @var Company|null
     */
    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: "companyFlights")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:companyFlights",
        "post:collection:companyFlights",
        "get:item:companyFlights"
    ])]
    private ?Company $company = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     * @return $this
     */
    public function setCompany(?Company $company): self
    {
        $this->company = $company;

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
     * @return CompanyFlights
     */
    public function setFromAirport(?Airport $fromAirport): self
    {
        $this->fromAirport = $fromAirport;

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
     * @return CompanyFlights
     */
    public function setToAirport(?Airport $toAirport): self
    {
        $this->toAirport = $toAirport;

        return $this;
    }

}
