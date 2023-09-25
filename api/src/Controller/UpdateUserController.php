<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UpdateUserController extends AbstractController
{

    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("update-user", methods: "PUT")]
    public function updateUserByEmail(Request $request): JsonResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            return $this->json(['message' => 'No user'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $user->setEmail($data["email"]);
        $user->setSurname($data['surname']);
        $user->setName($data['name']);
        $user->setPhoneNumber($data['phoneNumber']);

        $this->entityManager->flush();

        return $this->json(['message' => 'Profile was updates'], Response::HTTP_OK);
    }

}
