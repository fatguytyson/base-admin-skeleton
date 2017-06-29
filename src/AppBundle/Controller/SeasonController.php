<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Season controller.
 *
 * @Route("admin/season")
 */
class SeasonController extends Controller
{
    /**
     * Lists all season entities.
     *
     * @Menu("Seasons", route="admin_season_index", icon="calendar", order="2", group="admin", role="ROLE_USER")
     * @Route("/", name="admin_season_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $seasons = $em->getRepository('AppBundle:Season')->findAll();

        return $this->render('season/index.html.twig', array(
            'seasons' => $seasons,
        ));
    }

    /**
     * Creates a new season entity.
     *
     * @Route("/new", name="admin_season_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $season = new Season();
        $form = $this->createForm('AppBundle\Form\SeasonType', $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();

            return $this->redirectToRoute('admin_season_show', array('id' => $season->getId()));
        }

        return $this->render('season/new.html.twig', array(
            'season' => $season,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a season entity.
     *
     * @Route("/{id}", name="admin_season_show")
     * @Method("GET")
     */
    public function showAction(Season $season)
    {
        $deleteForm = $this->createDeleteForm($season);

        return $this->render('season/show.html.twig', array(
            'season' => $season,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing season entity.
     *
     * @Route("/{id}/edit", name="admin_season_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Season $season)
    {
        $deleteForm = $this->createDeleteForm($season);
        $editForm = $this->createForm('AppBundle\Form\SeasonType', $season);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_season_edit', array('id' => $season->getId()));
        }

        return $this->render('season/edit.html.twig', array(
            'season' => $season,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a season entity.
     *
     * @Route("/{id}", name="admin_season_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Season $season)
    {
        $form = $this->createDeleteForm($season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($season);
            $em->flush();
        }

        return $this->redirectToRoute('admin_season_index');
    }

    /**
     * Creates a form to delete a season entity.
     *
     * @param Season $season The season entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Season $season)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_season_delete', array('id' => $season->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
