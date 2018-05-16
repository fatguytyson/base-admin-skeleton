<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FGC\MenuBundle\Annotation\Menu;use Symfony\Component\HttpFoundation\Request;

/**
 * Rating controller.
 *
 * @Route("admin/rating")
 */
class RatingController extends Controller
{
    /**
     * Lists all rating entities.
     *
     * @Menu("Ratings", route="admin_rating_index", group="admin")
     * @Route("/", name="admin_rating_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ratings = $em->getRepository('AppBundle:Rating')->findAll();

        return $this->render('admin/rating/index.html.twig', array(
            'ratings' => $ratings,
        ));
    }

    /**
     * Creates a new rating entity.
     *
     * @Route("/new", name="admin_rating_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rating = new Rating();
        $form = $this->createForm('AppBundle\Form\RatingType', $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('admin_rating_show', array('id' => $rating->getId()));
        }

        return $this->render('admin/rating/new.html.twig', array(
            'rating' => $rating,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rating entity.
     *
     * @Route("/{id}", name="admin_rating_show")
     * @Method("GET")
     */
    public function showAction(Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);

        return $this->render('admin/rating/show.html.twig', array(
            'rating' => $rating,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rating entity.
     *
     * @Route("/{id}/edit", name="admin_rating_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);
        $editForm = $this->createForm('AppBundle\Form\RatingType', $rating);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_rating_edit', array('id' => $rating->getId()));
        }

        return $this->render('admin/rating/edit.html.twig', array(
            'rating' => $rating,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rating entity.
     *
     * @Route("/{id}", name="admin_rating_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rating $rating)
    {
        $form = $this->createDeleteForm($rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rating);
            $em->flush();
        }

        return $this->redirectToRoute('admin_rating_index');
    }

    /**
     * Creates a form to delete a rating entity.
     *
     * @param Rating $rating The rating entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rating $rating)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_rating_delete', array('id' => $rating->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
