<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AircraftRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AircraftRepository::class)]
#[UniqueEntity('serialNumber')]
#[ApiResource]
class Aircraft
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var AircraftModel|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AircraftModel $model = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, unique: true)]
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
    private array $places = [];

    /**
     * @var array
     */
    #[ORM\Column(type: Types::ARRAY)]
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
    public function setPlaces(array $places): static
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
    public function setColumns(array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }
}
