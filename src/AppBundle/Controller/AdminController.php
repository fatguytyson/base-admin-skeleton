<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\SiteSettings;
use AppBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * Lists all questionnaire entities.
     *
     * @Menu("Dashboard", route="dashboard", icon="dashboard", order=1, group="admin", role="ROLE_USER")
     * @Menu("Login", route="dashboard", order="1", group="footer")
     * @Route("/dashboard", name="dashboard", methods={"GET"})
     * @Route("/dashboard", name="questionnaire_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $questionnaires = $em->getRepository('AppBundle:Questionnaire')->findBy([],['id' => 'DESC']);

        return $this->render('questionnaire/index.html.twig', array(
            'questionnaires' => $questionnaires,
        ));
    }

    /**
     * Finds and displays a questionnaire entity.
     *
     * @Route("/questionnaire/{id}", name="questionnaire_show", methods={"GET"})
     */
    public function showAction(Questionnaire $questionnaire)
    {

        return $this->render('questionnaire/show.html.twig', array(
            'questionnaire' => $questionnaire,
        ));
    }

    /**
     * @Menu("Homepage", route="edit_page", routeOptions={"path"="homepage"}, icon="edit", order=2, group="admin", role="ROLE_ADMIN")
     * @Menu("About Me", route="edit_page", routeOptions={"path"="about_me"}, icon="edit", order=3, group="admin", role="ROLE_ADMIN")
     * @Menu("Go Green", route="edit_page", routeOptions={"path"="go_green"}, icon="edit", order=4, group="admin", role="ROLE_ADMIN")
     * @Menu("Esential Oils", route="edit_page", routeOptions={"path"="essential_oils"}, icon="edit", order=5, group="admin", role="ROLE_ADMIN")
     * @Menu("Events",   route="edit_page", routeOptions={"path"="events"},   icon="edit", order=6, group="admin", role="ROLE_ADMIN")
     * @Menu("Contact",  route="edit_page", routeOptions={"path"="contact"},  icon="edit", order=7, group="admin", role="ROLE_ADMIN")
     * @Route("/edit/{path}", name="edit_page")
     */
    public function editPageAction($path, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('AppBundle:Page')->findOneBy(['pageName' => $path]);
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em->flush();
            $this->addFlash('success', 'Page Saved!');
            return $this->redirectToRoute('edit_page', ['path' => $path]);
        }
        return $this->render('admin/edit.html.twig', ['pageName' => $path, 'form' => $form->createView()]);
    }

    /**
     * @Menu("Site Settings", route="site_settings", icon="cog", order=8, group="admin", role="ROLE_SUPER_ADMIN")
     * @Route("/site/settings", name="site_settings")
     */
    public function siteSettingsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ssr = $em->getRepository('AppBundle:SiteSettings');
        $settings = $ssr->findAll();

        $form = $this->createFormBuilder();
        /** @var SiteSettings $setting */
        foreach ($settings as $setting) {
            $form->add($setting->getTitle(), TextType::class);
            $form->get($setting->getTitle())->setData($setting->getValue());
        }
        $form = $form->getForm();

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $data = $form->getData();
            foreach($data as $key => $value) {
                $rec = $ssr->findOneBy(['title' => $key]);
                if ($rec->getValue() != $value) {
                    $rec->setValue($value);
                    $em->persist($rec);
                }
                $em->flush();
                $this->addFlash('success', 'Settings Saved!');
                return $this->redirectToRoute('site_settings');
            }
        }

        return $this->render(':admin:site_settings.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Menu("Media", route="media", icon="image", order=10, group="admin", role="ROLE_ADMIN")
     * @Route("/media/{folderPath}", name="media", requirements={"folderPath" = ".*"})
     */
    public function mediaAction(Request $request, $folderPath = '') //TODO: Add Image/Folder, delete Image/Folder
    {
        $finder = new Finder();
        $finder->in($this->getParameter('kernel.root_dir').'/../web/images/'.$folderPath);
        return $this->render(':admin:media.html.twig', ['folderPath' => $folderPath, 'files' => $finder]);
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
