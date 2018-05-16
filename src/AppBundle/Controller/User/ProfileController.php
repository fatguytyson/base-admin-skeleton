<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
namespace AppBundle\Controller\User;


use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserUserType;
use AppBundle\Util\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * Class ProfileController
 * @package AppBundle\Controller\User
 *
 * @Route("/user/profile")
 */
class ProfileController extends Controller
{
	/**
	 * Ability to change username and email
	 *
	 * @param Request $request
	 *
	 * @Route("/")
	 */
	public function accountAction(Request $request)
	{
		$user = $this->getUser();
		$form = $this->createForm(UserUserType::class, $user);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->get(UserManager::class)->updateUser($user);
			$this->addFlash('success', 'Account Information Updated.');
			$this->redirectToRoute("user_dashboard");
		}
		return $this->render('user/profile/accountedit.html.twig', [
			"form" => $form->createView()
		]);
	}

	/**
	 * Ability to change password
	 *
	 * @param Request $request
	 *
	 * @Route("/password")
	 */
	public function passwordAction(Request $request)
	{
		$user = $this->getUser();
		$form = $this->createForm(UserPasswordType::class, $user);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->get(UserManager::class)->updateUser($user);
			$this->addFlash('success', 'Password Updated.');
			$this->redirectToRoute("user_dashboard");
		}
		return $this->render('user/profile/passwordedit.html.twig', [
			"form" => $form->createView()
		]);
	}
}