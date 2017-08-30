<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
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

        $ret['header_image'] = ['path' => 'images/PhotoGrid_1502079214852.jpg', 'header' => 'A Green Oil Life', 'subhead' => 'A green way to improve your life.'];

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Menu("About Me", route="about_me", order="2")
     * @Route("/about-me", name="about_me", methods={"GET"})
     */
    public function aboutMeAction()
    {
        $ret = $this->getBaseInfo('about_me');

        $ret['header_image'] = ['path' => 'images/about-me-bg.jpg', 'header' => 'About Me', 'subhead' => 'Here is what I am about.'];

        return $this->render('default/about_me.html.twig', $ret);
    }

    /**
     * @Menu("Go Green", route="go_green", order="3")
     * @Route("/go-green", name="go_green", methods={"GET"})
     */
    public function goGreenAction()
    {
        $ret = $this->getBaseInfo('about_me');

        $ret['header_image'] = ['path' => 'images/about-me-bg.jpg', 'header' => 'About Me', 'subhead' => 'Here is what I am about.'];

        return $this->render('default/about_me.html.twig', $ret);
    }

    /**
     * @Menu("Events", route="events", order="4")
     * @Route("/events", name="events", methods={"GET"})
     */
    public function eventsAction()
    {
        $ret = $this->getBaseInfo('about_me');

        $ret['header_image'] = ['path' => 'images/about-me-bg.jpg', 'header' => 'About Me', 'subhead' => 'Here is what I am about.'];

        return $this->render('default/about_me.html.twig', $ret);
    }

    /**
     * @Menu("Contact", route="contact", order="5")
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function contactAction()
    {
        $ret = $this->getBaseInfo('contact');

        $ret['header_image'] = ['path' => 'images/homepage-bg.jpg', 'header' => 'Contact', 'subhead' => 'Have questions? I have answers (maybe).'];
        $form = $this->createForm(ContactType::class);
        $ret['form'] = $form->createView();

        return $this->render('default/contact.html.twig', $ret);
    }

    /**
     * @Route("/contact", name="contact_form", methods={"POST"})
     */
    public function contactFormAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $message = new \Swift_Message('A Message from your Contact Form', $this->renderView(':emails:contact.text.twig', $form->getData()), 'text/plain');
            $message->setSender('no-reply@'.$this->getParameter('site_domain'))->setFrom('no-reply@'.$this->getParameter('site_domain'))->setTo($this->getParameter('admin_email'));
            $this->get('swiftmailer.mailer')->send($message);
            $this->addFlash('success', 'Message has been sent!');
            return $this->redirectToRoute('homepage');
        }

        $ret = $this->getBaseInfo('contact');

        $ret['header_image'] = ['path' => 'images/homepage-bg.jpg', 'header' => 'Contact', 'subhead' => 'Have questions? I have answers (maybe).'];
        $ret['form'] = $form->createView();

        return $this->render('default/contact.html.twig', $ret);

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
                $ret['author'] = 'Nicole Green - A Green Oil Life';
                $ret['description'] = 'Resources to make life better';
                $ret['keywords'] = 'doTERRA, oil, las vegas, green, consultant';
                break;
        }
        return $ret;
    }
}
