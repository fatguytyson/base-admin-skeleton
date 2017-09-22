<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class AdminAreaController extends Controller
{
    /**
     * @Menu("Dashboard", route="admin_dashboard", icon="dashboard", order="1", group="admin", role="ROLE_ADMIN")
     * @Menu("Admin Area", route="admin_dashboard", order="3")
     * @Route("/", name="admin_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
