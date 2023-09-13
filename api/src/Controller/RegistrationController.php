<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
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
        EntityManagerInterface      $entityManager,
        ValidatorInterface          $validator,
        DenormalizerInterface       $denormalizer
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
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function registration(Request $request): JsonResponse
    {
        $user = $this->createUser($request);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(null, 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws Exception
     */
    #[Security("is_granted('" . User::ROLE_ADMIN . "') or is_granted('" . User::ROLE_OWNER . "')")]
    #[Route('/users', name: 'app_user_create', methods: ['POST'])]
    public function registerWorker(Request $request): JsonResponse
    {
        $user = $this->createUser($request);

        $currentUser = $this->getUser();
        $roles = $currentUser->getRoles();

        if (in_array(User::ROLE_ADMIN, $roles)) {
            $user->setRoles([User::ROLE_OWNER]);
        } else if (in_array(User::ROLE_OWNER, $roles)) {
            $user->setRoles([User::ROLE_MANAGER]);

            //check if company belongs to this owner
            $company = $user->getManagerAtCompany();
            if (is_null($company) || $company->getOwner() !== $currentUser) {
                throw new UnprocessableEntityHttpException("Wrong company");
            }
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user);
    }

    /**
     * @param Request $request
     * @return User
     * @throws ExceptionInterface
     * @throws Exception
     */
    private function createUser(Request $request): User
    {
        $content = $request->getContent();

        if (!$content) {
            throw new UnprocessableEntityHttpException("Data required");
        }

        $requestData = json_decode($request->getContent(), true);

        /** @var User $user */
        $user = $this->denormalizer->denormalize($requestData, User::class, "array");

        $this->validator->validate($user);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        //drop sensitive data
        $user->setManagerAtCompany(null);
        $user->setRoles([User::ROLE_USER]);
        $user->setMileBonuses(0);

        return $user;
    }
}