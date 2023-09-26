<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class GetUserByEmailController extends AbstractController
{

    /**
     * @var Security
     */
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return JsonResponse
     */
    #[Route('/username', name: 'get_username', methods: "GET")]
    public function index(): JsonResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $name = $user->getName();
        $surname = $user->getSurname();
        $phoneNumber = $user->getPhoneNumber();
        $email = $user->getEmail();
        $mileBonuses = $user->getMileBonuses();

        return $this->json([
            'name'        => $name,
            'surname'     => $surname,
            'phoneNumber' => $phoneNumber,
            'email'       => $email,
            'mileBonuses' => $mileBonuses
        ]);
    }

}
