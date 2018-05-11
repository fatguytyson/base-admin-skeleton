<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
namespace AppBundle\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class EmailKeyAuthenticator implements SimplePreAuthenticatorInterface
{
	public function createToken( Request $request, $providerKey ) {
		$apikey = $request->headers->get('apikey');
		if (!$apikey) {
			$apikey = $request->query->get('apikey');
		}
		if (!$apikey) {
			throw new BadCredentialsException('Must have a valid key to proceed.');
		}
		return new PreAuthenticatedToken('anon.', $apikey, $providerKey);
	}

	public function supportsToken( TokenInterface $token, $providerKey ) {
		return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
	}

	public function authenticateToken( TokenInterface $token, UserProviderInterface $userProvider, $providerKey ) {
		if (!$userProvider instanceof JobKeyProvider) {
			throw new \InvalidArgumentException(
				sprintf(
					'The user provider must be an instance of JobKeyProvider (%s was given).',
					get_class($userProvider)
				)
			);
		}

		$apiKey = $token->getCredentials();

//		// User is the Entity which represents your user TO STORE IN SESSION, ALSO CHANGE refreshUser TO RETURN $user
//		$user = $token->getUser();
//		if ($user instanceof User) {
//			return new PreAuthenticatedToken(
//				$user,
//				$apiKey,
//				$providerKey,
//				$user->getRoles()
//			);
//		}

		$user = $userProvider->loadUserByUsername($apiKey);

		if (!$user) {
			// CAUTION: this message will be returned to the client
			// (so don't put any un-trusted messages / error strings here)
			throw new CustomUserMessageAuthenticationException(
				sprintf('Key "%s" does not exist.', $apiKey)
			);
		}

		return new PreAuthenticatedToken(
			$user,
			$apiKey,
			$providerKey,
			$user->getRoles()
		);
	}
}