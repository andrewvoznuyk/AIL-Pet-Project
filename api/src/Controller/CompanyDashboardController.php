<?php

namespace App\Controller;

use App\Entity\CompanyFlights;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CompanyDashboardController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var NormalizerInterface
     */
    private NormalizerInterface $normalizer;

    /**
     * @param NormalizerInterface $normalizer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        NormalizerInterface    $normalizer,
        EntityManagerInterface $entityManager
    )
    {
        $this->normalizer = $normalizer;
        $this->entityManager = $entityManager;
    }

    /**
     * @param User|null $user
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/company-flights-test', name: 'get_company_flights', methods: ["GET"])]
    #[Security("is_granted(" . User::ROLE_OWNER . ") or is_granted(" . User::ROLE_MANAGER . ")")]
    public function getCompanyFlights(#[CurrentUser] ?User $user): JsonResponse
    {
        $company = null;

        if (in_array(User::ROLE_MANAGER, $user->getRoles())) {
            $company = $user->getManagerAtCompany();
        } else if (in_array(User::ROLE_OWNER, $user->getRoles())) {
            //$company
        }

        $companyFlights = $this->entityManager->getRepository(CompanyFlights::class)->findBy(["company" => $company]);

        $json = $this->normalizer->normalize($companyFlights, "array");

        return new JsonResponse($companyFlights);
    }

}
