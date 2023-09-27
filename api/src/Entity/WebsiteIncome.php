<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WebsiteIncomeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: WebsiteIncomeRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "method"                => "get",
            "security"              => "is_granted('" . User::ROLE_ADMIN . "')",
            "normalization_context" => ["groups" => ["get:collection:websiteIncome"]]
        ]
    ],
    itemOperations: [
        "get" => [
            "method"                => "get",
            "security"              => "is_granted('" . User::ROLE_ADMIN . "')",
            "normalization_context" => ["groups" => ["get:collection:websiteIncome"]]
        ],
    ]
)]
class WebsiteIncome
{

    /**
     * @var Uuid
     */
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    private Uuid $id;

    /**
     * @var CompanyIncome|null
     */
    #[ORM\OneToOne(cascade: [
        'persist',
        'remove'
    ])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyIncome $companyIncome = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $income = null;

    /**
     * @return Uuid|null
     */
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    /**
     * @return CompanyIncome|null
     */
    public function getCompanyIncome(): ?CompanyIncome
    {
        return $this->companyIncome;
    }

    /**
     * @param CompanyIncome $companyIncome
     * @return $this
     */
    public function setCompanyIncome(CompanyIncome $companyIncome): self
    {
        $this->companyIncome = $companyIncome;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIncome(): ?int
    {
        return $this->income;
    }

    /**
     * @param int $income
     * @return $this
     */
    public function setIncome(int $income): self
    {
        $this->income = $income;

        return $this;
    }

}
