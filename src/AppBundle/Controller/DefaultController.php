<?php

namespace AppBundle\Controller;

use FGC\MenuBundle\Annotation\Menu;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Menu("Home", route="homepage", order="1")
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $ret = $this->getBaseInfo('homepage');

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Route("/contact", name="contact_form", methods={"POST"})
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $this->get('app.mail_generator')->getMessage('contact', $request->request->get('form'));
            $message
                ->setSender('no-reply@'.$this->getParameter('site_domain'))
                ->setFrom('no-reply@'.$this->getParameter('site_domain'))
                ->setTo($this->getParameter('admin_email'));
            $this->get('mailer')->send($message);
            $this->addFlash('success', 'Message has been sent!');
        }
        return $this->redirectToRoute('homepage');
    }

    /**
     * @param $path
     * @return array
     */
    private function getBaseInfo($path)
    {
        $em = $this->getDoctrine()->getManager();

        $ret = [
            'canonical' => $this->generateUrl($path),
        ];
        switch ($path) {
            default:
            case 'homepage':
                $ret['author'] = 'author';
                $ret['description'] = 'description';
                $ret['keywords'] = 'keywords';
                break;
        }
        return $ret;
    }
}
