<?php

namespace App\Controller;

use App\Entity\CompanyIncome;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyStatController extends AbstractController
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
    #[Route('/get-company-stat', name: 'get_company_stat', methods: ['GET'])]
    public function getCompanyStat(): JsonResponse
    {
        $user = $this->getUser();

        if (!(in_array(User::ROLE_ADMIN, $user->getRoles()) || in_array(User::ROLE_MANAGER, $user->getRoles()) || in_array(User::ROLE_OWNER, $user->getRoles()) )) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $companyUser=$this->entityManager->getRepository(User::class)->findOneBy(['email'=>$user->getUserIdentifier()]);

        $companyStat = $this->entityManager->getRepository(CompanyIncome::class)->findStatOfDate($companyUser->getManagerAtCompany());

        foreach ($companyStat as &$result) {
            $formattedDate = (new \DateTime('1970-01-01'))->modify('+' . $result['date'] . ' days')->format('Y-m-d');
            $result['date'] = $formattedDate;
        }

        return new JsonResponse($companyStat);
    }
}