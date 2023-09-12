<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AircraftModelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
#[ApiResource]
class AircraftModel
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
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $code = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $manufacturer = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $businessPlaces = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $economPlaces = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $standartPlaces = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $rowsCount = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $rowWidth = null;

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
    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     * @return $this
     */
    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getBusinessPlaces(): ?int
    {
        return $this->businessPlaces;
    }

    /**
     * @param int $businessPlaces
     * @return $this
     */
    public function setBusinessPlaces(int $businessPlaces): self
    {
        $this->businessPlaces = $businessPlaces;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getEconomPlaces(): ?int
    {
        return $this->economPlaces;
    }

    /**
     * @param int $economPlaces
     * @return $this
     */
    public function setEconomPlaces(int $economPlaces): self
    {
        $this->economPlaces = $economPlaces;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStandartPlaces(): ?int
    {
        return $this->standartPlaces;
    }

    /**
     * @param int $standartPlaces
     * @return $this
     */
    public function setStandartPlaces(int $standartPlaces): self
    {
        $this->standartPlaces = $standartPlaces;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRowsCount(): ?int
    {
        return $this->rowsCount;
    }

    /**
     * @param int $rowsCount
     * @return $this
     */
    public function setRowsCount(int $rowsCount): self
    {
        $this->rowsCount = $rowsCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRowWidth(): ?int
    {
        return $this->rowWidth;
    }

    /**
     * @param int $rowWidth
     * @return $this
     */
    public function setRowWidth(int $rowWidth): self
    {
        $this->rowWidth = $rowWidth;

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
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return void
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }
}
