<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Action\DeleteCompanyFlightAction;
use App\Action\DeleteDeletableAction;
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
            // "security"              => "(is_granted('" . User::ROLE_OWNER . "') and object.company.getOwner() == user) or
            // ((is_granted('" . User::ROLE_MANAGER . "') and user.getManagerAtCompany() == object.company)",
            "normalization_context" => ["groups" => ["get:item:companyFlights"]]
        ],
        "softDelete" => [
            "method"     => "PUT",
            "path"       => "company-flights/delete/{id}",
            "security"   => "is_granted('" . User::ROLE_OWNER . "')",
            "normalization_context" => ["groups" => ["aircraft:empty"]],
            "controller" => DeleteDeletableAction::class
        ]
    ],
    attributes: [
        "security" => "is_granted('" . User::ROLE_ADMIN . "') or is_granted('" . User::ROLE_OWNER . "') or is_granted('" . User::ROLE_MANAGER . "')"
    ],
    order: ['id' => 'DESC']
)]
#[ApiFilter(SearchFilter::class, properties: [
    "airport.name"    => "partial",
    "airport.country" => "partial",
    "airport.city"    => "partial",
    "company.name"    => "partial"
])]
class CompanyFlights extends DeletableEntity
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:item:companyFlights",
        "get:collection:companyFlights"
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
        "post:collection:companyFlights"
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
