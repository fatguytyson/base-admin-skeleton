<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\CategorySTEData;
use AppBundle\Entity\CategoryType;
use AppBundle\Entity\SeasonTypeEntry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Menu("Dashboard", route="dashboard", icon="dashboard", order="1", group="admin", role="ROLE_USER")
     * @Menu("Admin Area", route="dashboard", order="2")
     * @Route("/", name="dashboard")
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        $season = $em->getRepository('AppBundle:Season')->getCurrentID();
        $data = $em->getRepository('AppBundle:CategoryType')->getSeasonData($season);

        $col = array();
        /** @var CategoryType $type */
        foreach($data as $type) {
            $cat = [];
            $panelTitle = $type->__toString();
            $col[$panelTitle] = array('type' => $panelTitle, 'element' => 'panel'.$panelTitle, 'data' => []);
            /** @var SeasonTypeEntry $ste */
            foreach($type->getSte() as $ste) {
                $col[$panelTitle]['data'][$ste->getEntry()->getTitle()] = [];
                /** @var CategorySTEData $csd */
                foreach($ste->getCsd() as $csd) {
                    $cat[] = $csd->getCategory()->getTitle();
                    $col[$panelTitle]['data'][$ste->getEntry()->getTitle()][] = [
                        'category' => $csd->getCategory()->getTitle(),
                        'data' => $type->getFlags() == (CategoryType::PHRASE | CategoryType::PERSON) ? $em->getRepository('AppBundle:Entry')->find($csd->getData())->getTitle() : $csd->getData()
                    ];
                }
            }
            $col[$panelTitle]['categories'] = array_flip(array_flip($cat));
        }
        return $this->render('admin/dashboard.html.twig', ['data' => $col]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render(':admin:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();
        return $this->redirectToRoute('homepage');
    }

}
