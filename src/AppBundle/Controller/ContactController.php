<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FGC\MenuBundle\Annotation\Menu;

/**
 * Contact controller.
 *
 * @Route("admin/contact")
 */
class ContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @Menu("Contacts", route="admin_contact_index", group="admin")
     * @Route("/", name="admin_contact_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('AppBundle:Contact')->findAll();

        return $this->render('contact/index.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * Finds and displays a contact entity.
     *
     * @Route("/{id}", name="admin_contact_show")
     * @Method("GET")
     */
    public function showAction(Contact $contact)
    {

        return $this->render('contact/show.html.twig', array(
            'contact' => $contact,
        ));
    }
}
