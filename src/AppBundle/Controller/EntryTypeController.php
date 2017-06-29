<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\EntryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Entrytype controller.
 *
 * @Route("admin/entrytype")
 */
class EntryTypeController extends Controller
{
    /**
     * Lists all entryType entities.
     *
     * @Menu("Entry Type", route="admin_entrytype_index", icon="address-card", order="5", group="admin", role="ROLE_USER")
     * @Route("/", name="admin_entrytype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entryTypes = $em->getRepository('AppBundle:EntryType')->findAll();

        return $this->render('entrytype/index.html.twig', array(
            'entryTypes' => $entryTypes,
        ));
    }

    /**
     * Creates a new entryType entity.
     *
     * @Route("/new", name="admin_entrytype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entryType = new Entrytype();
        $form = $this->createForm('AppBundle\Form\EntryTypeType', $entryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entryType);
            $em->flush();

            return $this->redirectToRoute('admin_entrytype_show', array('id' => $entryType->getId()));
        }

        return $this->render('entrytype/new.html.twig', array(
            'entryType' => $entryType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a entryType entity.
     *
     * @Route("/{id}", name="admin_entrytype_show")
     * @Method("GET")
     */
    public function showAction(EntryType $entryType)
    {
        $deleteForm = $this->createDeleteForm($entryType);

        return $this->render('entrytype/show.html.twig', array(
            'entryType' => $entryType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entryType entity.
     *
     * @Route("/{id}/edit", name="admin_entrytype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EntryType $entryType)
    {
        $deleteForm = $this->createDeleteForm($entryType);
        $editForm = $this->createForm('AppBundle\Form\EntryTypeType', $entryType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_entrytype_edit', array('id' => $entryType->getId()));
        }

        return $this->render('entrytype/edit.html.twig', array(
            'entryType' => $entryType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a entryType entity.
     *
     * @Route("/{id}", name="admin_entrytype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EntryType $entryType)
    {
        $form = $this->createDeleteForm($entryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entryType);
            $em->flush();
        }

        return $this->redirectToRoute('admin_entrytype_index');
    }

    /**
     * Creates a form to delete a entryType entity.
     *
     * @param EntryType $entryType The entryType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EntryType $entryType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_entrytype_delete', array('id' => $entryType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
