<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace AppBundle\Controller\Admin;

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

        return $this->render('admin/contact/index.html.twig', array(
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

        return $this->render('admin/contact/show.html.twig', array(
            'contact' => $contact,
        ));
    }
}
