<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\Questionnaire;
use AppBundle\Form\ContactType;
use AppBundle\Form\QuestionnaireType;
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
     * @Menu("About Me", route="about_me", order="2")
     * @Route("/about-me", name="about_me", methods={"GET"})
     */
    public function aboutMeAction()
    {
        $ret = $this->getBaseInfo('about_me');

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Menu("Go Green", route="go_green", order="3")
     * @Route("/go-green", name="go_green", methods={"GET"})
     */
    public function goGreenAction()
    {
        $ret = $this->getBaseInfo('go_green');

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Menu("Essential Oils", route="essential_oils", order="4")
     * @Route("/essential-oils", name="essential_oils", methods={"GET"})
     */
    public function essentialOilsAction()
    {
        $ret = $this->getBaseInfo('essential_oils');

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Menu("Events", route="events", order="5")
     * @Route("/events", name="events", methods={"GET"})
     */
    public function eventsAction()
    {
        $ret = $this->getBaseInfo('events');

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Menu("Contact", route="contact", order="6")
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function contactAction()
    {
        $ret = $this->getBaseInfo('contact');

        return $this->render('default/index.html.twig', $ret);
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

        $ret['form'] = $form->createView();

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Route("/questionnaire", name="question_form", methods={"POST"})
     */
    public function questionFormAction(Request $request)
    {
        $question = new Questionnaire();
        $form = $this->createForm(QuestionnaireType::class, $question);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $message = new \Swift_Message('A Message from your Question Form', $this->renderView(':emails:question.text.twig', $form->getData()->toArray()), 'text/plain');
            $message->setSender('no-reply@'.$this->getParameter('site_domain'))->setFrom('no-reply@'.$this->getParameter('site_domain'))->setTo($this->getParameter('admin_email'));
            $this->get('swiftmailer.mailer')->send($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
            return $this->render(':sprites:modal.html.twig', ['question' => $form->createView(), 'complete' => true]);
        }

        return $this->render(':sprites:modal.html.twig', ['question' => $form->createView(), 'complete' => false]);
    }

    /**
     * @param $path
     * @return array
     */
    private function getBaseInfo($path)
    {
        $em = $this->getDoctrine()->getManager();

        $questionnaire = $this->createForm(QuestionnaireType::class);

        $page = $em->getRepository('AppBundle:Page')->findOneBy(['pageName' => $path]);

        $ret = [
            'canonical' => $this->generateUrl($path),
            'author' => 'Nicole Green - A Green Oil Life',
            'description' => 'Resources to make life better',
            'keywords' => 'doTERRA, oil, las vegas, green, consultant',
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
            'question' => $questionnaire->createView(),
        ];

        $flags = explode(',', $page->getFlags());

        foreach ($flags as &$flag) {
            $template = $em->getRepository('AppBundle:SiteSettings')->findOneBy(['title' => $flag]);
            if ($template) {
                $flag = $template->getValue();
            } else {
                unset($flag);
            }
        }

        $ret['flags'] = $flags;

        $ret['header_image'] = ['path' => $page->getBgImage(), 'header' => $page->getHeader(), 'subhead' => $page->getSubheader()];

        switch ($path) {
            default:
            case 'homepage':
                $ret['testimonials'] = $em->getRepository('AppBundle:Testimonial')->findAll();
                break;
            case 'contact':
                $form = $this->createForm(ContactType::class);
                $ret['form'] = $form->createView();
                break;
            case 'events':
                $ret['events'] = $em->getRepository('AppBundle:Event')->findUpcoming();
                break;
        }
        return $ret;
    }
}
