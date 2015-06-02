<?php

namespace Mamidi\ClassifiedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mamidi\ClassifiedBundle\Entity\Meal;
use Mamidi\ClassifiedBundle\Form\MealType;

/**
 * Meal controller.
 *
 * @Route("/meal")
 */
class MealController extends Controller
{

    /**
     * Lists all Meal entities.
     *
     * @Route("/", name="meal")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MamidiClassifiedBundle:Meal')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Meal entity.
     *
     * @Route("/", name="meal_create")
     * @Method("POST")
     * @Template("MamidiClassifiedBundle:Meal:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Meal();
        $current_user = $this->container->get('security.context')->getToken()->getUser();
        $entity->setHost($current_user);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('meal_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Meal entity.
     *
     * @param Meal $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Meal $entity)
    {
        $form = $this->createForm(new MealType(), $entity, array(
            'action' => $this->generateUrl('meal_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Meal entity.
     *
     * @Route("/new", name="meal_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Meal();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Meal entity.
     *
     * @Route("/{id}", name="meal_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MamidiClassifiedBundle:Meal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Meal entity.
     *
     * @Route("/{id}/edit", name="meal_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MamidiClassifiedBundle:Meal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meal entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Meal entity.
    *
    * @param Meal $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Meal $entity)
    {
        $form = $this->createForm(new MealType(), $entity, array(
            'action' => $this->generateUrl('meal_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Meal entity.
     *
     * @Route("/{id}", name="meal_update")
     * @Method("PUT")
     * @Template("MamidiClassifiedBundle:Meal:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MamidiClassifiedBundle:Meal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Meal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('meal_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Meal entity.
     *
     * @Route("/{id}", name="meal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MamidiClassifiedBundle:Meal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Meal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('meal'));
    }

    /**
     * Creates a form to delete a Meal entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('meal_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
