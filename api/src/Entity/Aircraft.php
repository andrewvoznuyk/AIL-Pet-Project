<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AircraftRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AircraftRepository::class)]
#[UniqueEntity('serialNumber')]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:collection:aircraft"]]
        ]
    ],
    itemOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:item:aircraft"]]
        ]
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    "aircraftModel" => "partial",
    "serialNumber" => "partial",
])]
class Aircraft
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:collection:aircraft",
        "get:item:aircraft",
        "get:collection:flight",
        "get:item:flight"
    ])]
    private ?int $id = null;

    /**
     * @var AircraftModel|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        "get:collection:aircraft",
        "get:item:aircraft"
    ])]
    private ?AircraftModel $model = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, unique: true)]
    #[Groups([
        "get:collection:aircraft",
        "get:item:aircraft",
        "get:item:flight",
        "get:collection:flight"
    ])]
    private ?string $serialNumber = null;

    /**
     * @var Company|null
     */
    #[ORM\ManyToOne(inversedBy: 'aircrafts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    /**
     * @var array
     */
    #[ORM\Column]
    #[Groups([
        "get:collection:aircraft",
        "get:item:aircraft",
        "get:item:flight",
        "get:collection:flight"
    ])]
    private array $places = [];

    /**
     * @var array
     */
    #[ORM\Column(type: Types::JSON)]
    private array $columns = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return AircraftModel|null
     */
    public function getModel(): ?AircraftModel
    {
        return $this->model;
    }

    /**
     * @param AircraftModel|null $model
     * @return $this
     */
    public function setModel(?AircraftModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     * @return $this
     */
    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
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
     * @return array
     */
    public function getPlaces(): array
    {
        return $this->places;
    }

    /**
     * @param array $places
     * @return $this
     */
    public function setPlaces(array $places): self
    {
        $this->places = $places;

        return $this;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;

        return $this;
    }
}
