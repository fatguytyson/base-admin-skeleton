<?php
namespace AppBundle\Util;

use AppBundle\Entity\User;

interface UserManagerInterface
{
	/**
	 * Returns an empty user instance
	 *
	 * @return User
	 */
    public function createUser();

	/**
	 * Finds a user by email
	 *
	 * @param string $email
	 *
	 * @return User
	 */
    public function findUserByEmail($email);

	/**
	 * Finds a user by username
	 *
	 * @param string $username
	 *
	 * @return User
	 */
    public function findUserByUsername($username);

	/**
	 * Finds a user either by email, or username
	 *
	 * @param string $usernameOrEmail
	 *
	 * @return User
	 */
    public function findUserByUsernameOrEmail($usernameOrEmail);

	/**
	 * Finds a user either by confirmation token
	 *
	 * @param string $token
	 *
	 * @return User
	 */
    public function findUserByConfirmationToken($token);

	/**
	 * @param User $user
	 *
	 * @return void
	 */
    public function updateCanonicalFields(User $user);

	/**
	 * @param User $user
	 *
	 * @return void
	 */
    public function updatePassword(User $user);

	/**
	 * @param User $user
	 *
	 * @return void
	 */
    public function deleteUser(User $user);

	/**
	 * @return string
	 */
    public function getClass();

	/**
	 * @param array $criteria
	 *
	 * @return User|null
	 */
    public function findUserBy(array $criteria);

	/**
	 * @return array
	 */
    public function findUsers();

	/**
	 * @param User $user
	 *
	 * @return void
	 */
    public function reloadUser(User $user);

	/**
	 * Updates a user.
	 *
	 * @param User      $user
	 * @param Boolean   $andFlush Whether to flush the changes (default true)
	 */
    public function updateUser(User $user, $andFlush = true);
}