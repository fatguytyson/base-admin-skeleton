<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\Testimonial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Testimonial controller.
 *
 * @Route("admin/testimonial")
 */
class TestimonialController extends Controller
{
    /**
     * Lists all testimonial entities.
     *
     * @Menu("Edit Testimonials", route="admin_testimonial_index", icon="list", order=9, group="admin", role="ROLE_ADMIN")
     * @Route("/", name="admin_testimonial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $testimonials = $em->getRepository('AppBundle:Testimonial')->findAll();

        return $this->render('testimonial/index.html.twig', array(
            'testimonials' => $testimonials,
        ));
    }

    /**
     * Creates a new testimonial entity.
     *
     * @Route("/new", name="admin_testimonial_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $testimonial = new Testimonial();
        $form = $this->createForm('AppBundle\Form\TestimonialType', $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($testimonial);
            $em->flush();

            return $this->redirectToRoute('admin_testimonial_show', array('id' => $testimonial->getId()));
        }

        return $this->render('testimonial/new.html.twig', array(
            'testimonial' => $testimonial,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a testimonial entity.
     *
     * @Route("/{id}", name="admin_testimonial_show")
     * @Method("GET")
     */
    public function showAction(Testimonial $testimonial)
    {
        $deleteForm = $this->createDeleteForm($testimonial);

        return $this->render('testimonial/show.html.twig', array(
            'testimonial' => $testimonial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing testimonial entity.
     *
     * @Route("/{id}/edit", name="admin_testimonial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Testimonial $testimonial)
    {
        $deleteForm = $this->createDeleteForm($testimonial);
        $editForm = $this->createForm('AppBundle\Form\TestimonialType', $testimonial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_testimonial_edit', array('id' => $testimonial->getId()));
        }

        return $this->render('testimonial/edit.html.twig', array(
            'testimonial' => $testimonial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a testimonial entity.
     *
     * @Route("/{id}", name="admin_testimonial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Testimonial $testimonial)
    {
        $form = $this->createDeleteForm($testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($testimonial);
            $em->flush();
        }

        return $this->redirectToRoute('admin_testimonial_index');
    }

    /**
     * Creates a form to delete a testimonial entity.
     *
     * @param Testimonial $testimonial The testimonial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Testimonial $testimonial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_testimonial_delete', array('id' => $testimonial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
