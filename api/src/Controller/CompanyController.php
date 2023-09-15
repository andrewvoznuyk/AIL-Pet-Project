<?php

namespace App\Controller;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CompanyController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return JsonResponse
     */
    #[Route('/user-company', name: 'app_user_company', methods: ['GET'])]
    public function getOwnerCompany(): JsonResponse
    {
        $user = $this->getUser();

        $userCompanies = $this->entityManager->getRepository(Company::class)->findBy(['owner' => $user]);

        $companyData = [];
        foreach ($userCompanies as $company) {
            $companyData[] = [
                'id'   => $company->getId(),
                'name' => $company->getName(),
                'date' => $company->getDate()
            ];
        }

        return new JsonResponse($companyData);
    }

}