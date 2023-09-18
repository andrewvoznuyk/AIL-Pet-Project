<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Action\GetAircraftModelApiAction;
use App\Repository\AircraftModelRepository;
use App\Services\GetApiDataService;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"           => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:collection:model"]]
        ],
        "post"          => [
            "method"                  => "POST",
            "security"                => "is_granted('" . User::ROLE_ADMIN . "')",
            "denormalization_context" => ["groups" => ["post:collection:model"]],
            "normalization_context"   => ["groups" => ["get:item:model"]],
        ],
        "post-aircraft" => [
            "method"                  => "POST",
            "path"                    => "get-aircrafts",
            "security"                => "is_granted('" . User::ROLE_ADMIN . "')",
            "controller"              => GetAircraftModelApiAction::class
        ]
    ],
    itemOperations: [
        "get" => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:item:model"]]
        ],
        "put" => [
            "method"                  => "PUT",
            "security"                => "is_granted('" . User::ROLE_ADMIN . "')",
            "denormalization_context" => ["groups" => ["post:item:model"]],
            "normalization_context"   => ["groups" => ["get:item:model"]]
        ]
    ]
)]
class AircraftModel
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:item:model",
        "get:collection:model"
    ])]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model",
        "post:collection:model"
    ])]
    private ?string $plane = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model",
        "post:collection:model"
    ])]
    private ?string $brand = null;

    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model",
        "post:collection:model"
    ])]
    private ?int $passenger_capacity = null;

    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model",
        "post:collection:model"
    ])]
    private ?int $cruise_speed_kmph = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model",
        "post:collection:model"
    ])]
    private ?string $engine = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model",
        "post:collection:model"
    ])]
    private ?string $imgThumb = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getPlane(): ?string
    {
        return $this->plane;
    }

    /**
     * @param string $plane
     * @return $this
     */
    public function setPlane(string $plane): self
    {
        $this->plane = $plane;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return $this
     */
    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngine(): ?string
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     * @return $this
     */
    public function setEngine(string $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImgThumb(): ?string
    {
        return $this->imgThumb;
    }

    /**
     * @param string $imgThumb
     * @return $this
     */
    public function setImgThumb(string $imgThumb): self
    {
        $this->imgThumb = $imgThumb;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPassengerCapacity(): ?int
    {
        return $this->passenger_capacity;
    }

    /**
     * @param int $passenger_capacity
     * @return $this
     */
    public function setPassengerCapacity(int $passenger_capacity): self
    {
        $this->passenger_capacity = $passenger_capacity;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCruiseSpeedKmph(): ?int
    {
        return $this->cruise_speed_kmph;
    }

    /**
     * @param int $cruise_speed_kmph
     * @return $this
     */
    public function setCruiseSpeedKmph(int $cruise_speed_kmph): self
    {
        $this->cruise_speed_kmph = $cruise_speed_kmph;

        return $this;
    }

}
