<?php

namespace AppBundle\Util;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Abstract User Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class UserManager
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var CanonicalizerInterface
     */
    protected $usernameCanonicalizer;

    /**
     * @var CanonicalizerInterface
     */
    protected $emailCanonicalizer;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface  $usernameCanonicalizer
     * @param CanonicalizerInterface  $emailCanonicalizer
     * @param EntityManager           $em
     */
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, EntityManager $em)
    {
        $this->encoderFactory = $encoderFactory;
        $this->usernameCanonicalizer = $usernameCanonicalizer;
        $this->emailCanonicalizer = $emailCanonicalizer;
        $this->entityManager = $em;
        $this->repository = $em->getRepository("AppBundle:User");

        $this->class = 'AppBundle\\Entity\\User';
    }

    /**
     * Returns an empty user instance
     *
     * @return User
     */
    public function createUser()
    {
        $user = new $this->class;

        return $user;
    }

    /**
     * Finds a user by email
     *
     * @param string $email
     *
     * @return User
     */
    public function findUserByEmail($email)
    {
        return $this->findUserBy(array('emailCanon' => $this->canonicalizeEmail($email)));
    }

    /**
     * Finds a user by username
     *
     * @param string $username
     *
     * @return User
     */
    public function findUserByUsername($username)
    {
        return $this->findUserBy(array('usernameCanon' => $this->canonicalizeUsername($username)));
    }

    /**
     * Finds a user either by email, or username
     *
     * @param string $usernameOrEmail
     *
     * @return User
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * Finds a user either by confirmation token
     *
     * @param string $token
     *
     * @return User
     */
    public function findUserByConfirmationToken($token)
    {
        return $this->findUserBy(array('confirmationToken' => $token));
    }

    /**
     * {@inheritDoc}
     */
    public function updateCanonicalFields(User $user)
    {
        $user->setUsernameCanon($this->canonicalizeUsername($user->getUsername()));
        $user->setEmailCanon($this->canonicalizeEmail($user->getEmail()));
    }

    /**
     * {@inheritDoc}
     */
    public function updatePassword(User $user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }
    }

    /**
     * Canonicalizes an email
     *
     * @param string $email
     *
     * @return string
     */
    protected function canonicalizeEmail($email)
    {
        return $this->emailCanonicalizer->canonicalize($email);
    }

    /**
     * Canonicalizes a username
     *
     * @param string $username
     *
     * @return string
     */
    protected function canonicalizeUsername($username)
    {
        return $this->usernameCanonicalizer->canonicalize($username);
    }

    protected function getEncoder(User $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteUser(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function findUserBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findUsers()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function reloadUser(User $user)
    {
        $this->entityManager->refresh($user);
    }

    /**
     * Updates a user.
     *
     * @param User      $user
     * @param Boolean   $andFlush Whether to flush the changes (default true)
     */
    public function updateUser(User $user, $andFlush = true)
    {
        $this->updateCanonicalFields($user);
        $this->updatePassword($user);

        $this->entityManager->persist($user);
        if ($andFlush) {
            $this->entityManager->flush();
        }
    }
}
