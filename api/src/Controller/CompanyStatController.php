<?php

namespace App\Controller;

use App\Entity\CompanyIncome;
use App\Entity\User;
use App\Entity\WebsiteIncome;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/get-website-stat', name: 'get_website_stat', methods: ['GET'])]
    public function getWebsiteStat(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(User::ROLE_ADMIN, $user->getRoles()))
        {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $num = $request->query->get('num');

        if($num==1)
        {
            $stat = $this->entityManager->getRepository(WebsiteIncome::class)->findStatOfDateAdmin();
        }

        else if($num==2)
        {
            $stat = $this->entityManager->getRepository(WebsiteIncome::class)->findStatOfCompanyAdmin();
        }

        if (isset($stat[0]['date']))
        {
            foreach ($stat as &$result)
            {
                $formattedDate = (new \DateTime('1970-01-01'))->modify('+' . $result['date'] . ' days')->format('Y-m-d');
                $result['date'] = $formattedDate;
            }
        }

        return new JsonResponse($stat);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/get-company-stat', name: 'get_company_stat', methods: ['GET'])]
    public function getCompanyStat(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(User::ROLE_MANAGER, $user->getRoles()))
        {
            $companyUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUserIdentifier()]);
            $companyStat = $this->searchStat($companyUser, User::ROLE_MANAGER);
        }

        else if (in_array(User::ROLE_OWNER, $user->getRoles()))
        {
            $companyId = $request->query->get('id');
            $companyStat = $this->searchStat($companyId, User::ROLE_OWNER);
        }

        else
        {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($companyStat);
    }

    /**
     * @param $company
     * @param $role
     * @return array
     */
    public function searchStat($company, $role): array
    {

        $companyStat = [];

        if ($role === User::ROLE_MANAGER)
        {
            $companyStat = $this->entityManager->getRepository(CompanyIncome::class)->findStatOfDate($company->getManagerAtCompany());
        }

        else if ($role === User::ROLE_OWNER)
        {
            $companyStat = $this->entityManager->getRepository(CompanyIncome::class)->findStatOfDate($company);
        }

        foreach ($companyStat as &$result) {
            $formattedDate = (new \DateTime('1970-01-01'))->modify('+' . $result['date'] . ' days')->format('Y-m-d');
            $result['date'] = $formattedDate;
        }

        return $companyStat;
    }
}