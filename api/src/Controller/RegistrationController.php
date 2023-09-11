<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class RegistrationController extends AbstractController
{

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        DenormalizerInterface $denormalizer
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/registration', name: 'app_registration', methods: ['POST'])]
    public function registration(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $user = $this->denormalizer->denormalize($requestData, User::class, "array");

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $this->validator->validate($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user);
    }
}