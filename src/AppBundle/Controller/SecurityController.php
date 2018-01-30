<?php
namespace AppBundle\Controller;

use AppBundle\Form\ResetType;
use AppBundle\Util\TokenGeneratorInterface;
use AppBundle\Util\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/user")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/login-check", name="login_check")
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

    /**
     * @Route("/resetting", name="resetting")
     */
    public function resettingAction()
    {
        return $this->render('security/resetting.html.twig');
    }

    /**
     * @Route("/resetting/send-email", name="resetting_send_email")
     */
    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('_username');

        $user = $this->get('AppBundle\Util\UserManagerInterface::class')->findUserByUsernameOrEmail($username);

        if ($user !== null && $user->isPasswordRequestNonExpired()) {
            if (null === $user->getConfirmationToken()) {
                /** @var $tokenGenerator TokenGeneratorInterface */
                $tokenGenerator = $this->get('app.token_generator');
                $user->setConfirmationToken($tokenGenerator->generateToken());
            }

            $message = $this->get('app.mail_generator')->getMessage('reset_email', array('user' => $user));
            $message->setFrom('noreply@'.$this->getParameter('site_domain'))
                ->setTo($user->getEmailCanon());
            $this->get('mailer')->send($message);
            $user->setPasswordRequestedAt(new \DateTime());
            $this->get('AppBundle\Util\UserManagerInterface::class')->updateUser($user);
        }

        return $this->redirectToRoute('resetting_check_email', array('username' => $username));
    }

    /**
     * @Route("/resetting/check-email", name="resetting_check_email")
     */
    public function checkEmailAction(Request $request)
    {
        $username = $request->query->get('username');

        if (empty($username)) {
            // the user does not come from the sendEmail action
            return $this->redirectToRoute('resetting');
        }

        return $this->render('security/check_email.html.twig');
    }

    /**
     * @Route("/resetting/reset/{token}", name="resetting_reset")
     */
    public function resetAction(Request $request, $token)
    {
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('AppBundle\Util\UserManagerInterface::class');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $form = $this->createForm(ResetType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->updateUser($user);

            return $this->redirectToRoute('user_dashboard');
        }

        return $this->render('security/reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
}