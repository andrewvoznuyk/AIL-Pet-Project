<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
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
#[ApiFilter(SearchFilter::class, properties: [
    "airport.name"    => "partial",
    "airport.country" => "partial",
    "airport.city"    => "partial",
])]
class CompanyFlights
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
     * @var Airport|null
     */
    #[ORM\ManyToOne(targetEntity: Airport::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:companyFlights",
        "post:collection:companyFlights",
        "get:item:companyFlights",

        "get:item:flight",
        "get:collection:flight"
    ])]
    private ?Airport $airport = null;

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
    public function getAirport(): ?Airport
    {
        return $this->airport;
    }

    /**
     * @param Airport|null $airport
     * @return CompanyFlights
     */
    public function setAirport(?Airport $airport): self
    {
        $this->airport = $airport;

        return $this;
    }

}
