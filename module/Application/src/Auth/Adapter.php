<?php

namespace Application\Auth;

use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

/**
 * Class Adapter
 * @package Application\Auth
 */
class Adapter implements AdapterInterface
{

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Adapter constructor.
     * @param string $email
     * @param string $password
     * @param EntityManager $entityManager
     */
    public function __construct(string $email, string $password, EntityManager $entityManager)
    {
        $this->email = $email;
        $this->password = $password;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Result
     */
    public function authenticate()
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(
            [
                'email' => $this->email,
                'password' => User::encryptPassword($this->password)
            ]
        );

        if (null === $user) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null);
        } elseif (false === $user->getActive()) {
            return new Result(Result::FAILURE_IDENTITY_AMBIGUOUS, null);
        } else {
            return new Result(Result::SUCCESS, $user->getId());
        }
    }

}