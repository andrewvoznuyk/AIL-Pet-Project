<?php

namespace App\Validator\Constraints;

use App\Entity\Aircraft;
use App\Entity\Airport;
use App\Entity\Company;
use App\Entity\CompanyFlights;
use App\Entity\CompanyIncome;
use App\Entity\Flight;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CompanyIncomeConstraintValidator extends ConstraintValidator
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security               $security
    )
    {
    }

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof CompanyIncomeConstraint) {
            throw new UnexpectedTypeException($constraint, CompanyIncomeConstraint::class);
        }

        if (!$value instanceof CompanyIncome) {
            throw new UnexpectedTypeException($constraint, CompanyIncome::class);
        }

        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        //check if this report already exists
        if(!empty($this->entityManager
            ->getRepository(CompanyIncome::class)
            ->findOneBy(["flight" => $value->getFlight()]))){
            $this->context->addViolation("Report already exists!");
        }
    }

}