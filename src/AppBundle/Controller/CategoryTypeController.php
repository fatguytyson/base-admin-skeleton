<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Categorytype controller.
 *
 * @Route("admin/categorytype")
 */
class CategoryTypeController extends Controller
{
    /**
     * Lists all categoryType entities.
     *
     * @Menu("Category Type", route="admin_categorytype_index", icon="id-card", order="3", group="admin", role="ROLE_USER")
     * @Route("/", name="admin_categorytype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoryTypes = $em->getRepository('AppBundle:CategoryType')->findAll();

        return $this->render('categorytype/index.html.twig', array(
            'categoryTypes' => $categoryTypes,
        ));
    }

    /**
     * Creates a new categoryType entity.
     *
     * @Route("/new", name="admin_categorytype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoryType = new Categorytype();
        $form = $this->createForm('AppBundle\Form\CategoryTypeType', $categoryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoryType);
            $em->flush();

            return $this->redirectToRoute('admin_categorytype_show', array('id' => $categoryType->getId()));
        }

        return $this->render('categorytype/new.html.twig', array(
            'categoryType' => $categoryType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categoryType entity.
     *
     * @Route("/{id}", name="admin_categorytype_show")
     * @Method("GET")
     */
    public function showAction(CategoryType $categoryType)
    {
        $deleteForm = $this->createDeleteForm($categoryType);

        return $this->render('categorytype/show.html.twig', array(
            'categoryType' => $categoryType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categoryType entity.
     *
     * @Route("/{id}/edit", name="admin_categorytype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CategoryType $categoryType)
    {
        $deleteForm = $this->createDeleteForm($categoryType);
        $editForm = $this->createForm('AppBundle\Form\CategoryTypeType', $categoryType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_categorytype_edit', array('id' => $categoryType->getId()));
        }

        return $this->render('categorytype/edit.html.twig', array(
            'categoryType' => $categoryType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categoryType entity.
     *
     * @Route("/{id}", name="admin_categorytype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategoryType $categoryType)
    {
        $form = $this->createDeleteForm($categoryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categoryType);
            $em->flush();
        }

        return $this->redirectToRoute('admin_categorytype_index');
    }

    /**
     * Creates a form to delete a categoryType entity.
     *
     * @param CategoryType $categoryType The categoryType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoryType $categoryType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_categorytype_delete', array('id' => $categoryType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
