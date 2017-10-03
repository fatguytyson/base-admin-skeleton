<?php

namespace AppBundle\Controller;

use FGC\MenuBundle\Annotation\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/user")
 */
class UserAreaController extends Controller
{
    /**
     * @Menu("Dashboard", route="user_dashboard", icon="dashboard", order="1", group="user", role="ROLE_USER")
     * @Menu("User Area", route="user_dashboard", order="2")
     * @Route("/", name="user_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('user/dashboard.html.twig');
    }
}
