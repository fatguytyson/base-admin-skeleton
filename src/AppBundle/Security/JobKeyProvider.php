<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
namespace AppBundle\Security;


use AppBundle\Util\JobManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JobKeyProvider implements UserProviderInterface {
	/**
	 * @var JobManagerInterface
	 */
	protected $um;

	/**
	 * Constructor.
	 *
	 * @param JobManagerInterface $um
	 */
	public function __construct(JobManagerInterface $um)
	{
		$this->um = $um;
	}

	/**
	 * {@inheritDoc)
	 */
	public function loadUserByUsername( $username ) {
		$job = $this->um->findJobByKey($username);
		if (!$job) {
			throw new UsernameNotFoundException(sprintf('No job with email key: %s.', $username));
		}
		// TODO: Load real User if exists.
		return new User($job->getEmail(), null, ['ROLE_EMAIL_USER']);
	}

	public function refreshUser(UserInterface $user)
	{
		// this is used for storing authentication in the session
		// but in this example, the token is sent in each request,
		// so authentication can be stateless. Throwing this exception
		// is proper to make things stateless
		throw new UnsupportedUserException();
	}

	public function supportsClass($class)
	{
		return User::class === $class;
	}}