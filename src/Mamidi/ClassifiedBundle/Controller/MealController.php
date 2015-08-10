<?php

namespace Mamidi\ClassifiedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;

use Mamidi\ClassifiedBundle\Entity\Meal;
use Mamidi\ClassifiedBundle\Form\MealType;
use Mamidi\ClassifiedBundle\Entity\Reservation;

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
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MamidiClassifiedBundle:Meal')->findAll();
        $current_user = $this->container->get('security.context')->getToken()->getUser();

        return array(
            'entities' => $entities,
            'guest' => $current_user
        );
    }
    /**
     * Creates a new Meal entity.
     *
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

            $session = new Session();
            $session->getFlashBag()->add(
                'success',
                'Le repas a été créé'
            );

//            return $this->redirect($this->getRequest()->headers->get('referer'));
            return $this->redirect($this->generateUrl('host_meals', array('host' => $current_user)));
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

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Meal entity.
     *
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

        $isCurrentHost = false;
        $formula = false;
        $current_user = $this->container->get('security.context')->getToken()->getUser();
        if ($current_user != "anon."){
            $isCurrentHost =  ($current_user->getId() == $entity->getHost()->getId());
            $reservation = $entity->getReservationBy($current_user);
            if ($reservation !== false) {
                $formula = $reservation->getFormula();
            }
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'formula'     => $formula,
            'is_current_host' => $isCurrentHost,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Meal entity.
     *
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

//        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Meal entity.
     *
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

            $session = new Session();
            $session->getFlashBag()->add(
                'success',
                'Le repas a été supprimé'
            );
        }

        $current_user = $this->container->get('security.context')->getToken()->getUser();
        return $this->redirect($this->generateUrl('host_meals', array('host' => $current_user)));
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
            ->getForm()
        ;
    }

    /**
     * Create a Reservation for this meal
     *
     * @Route("/meal/{id}/book/", name="meal_book")
     * @Method("POST")
     * @Security("has_role('ROLE_GUEST')")
     *
     */
    public function bookAction(Request $request, Meal $meal)
    {
        $form = $this->createBookForm($meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reservation = new Reservation();
            $reservation->setGuest($this->getUser());
            $reservation->setMeal($meal);
            $reservation->setFormula($form->get('formula')->getData());
            $reservation->setDate(new \DateTime("now"));
            $em->persist($reservation);
            $em->flush();

            $session = new Session();
            $session->getFlashBag()->add(
                'success',
                'La place a été réservée'
            );
        }

        return $this->redirectToRoute('meal');
    }

    /**
     * @Route("/meal/{id}/book_form", name="meal_book_form")
     * @Method("POST")
     *
     */
    public function book_formAction(Meal $id)
    {
        $bookForm = $this->createBookForm($id);
        return $this->render("@MamidiClassified/Meal/book_form.html.twig", array("book_form" => $bookForm->createView()));
    }

    /**
     * Creates a form to add a Reservation for a Meal
     *
     * @param Meal $meal The meal object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBookForm(Meal $meal)
    {
        $available_formulas = array();
        foreach ($meal->getFormulas() as $formula) {
            $available_formulas[$formula] = Meal::$formulas[$formula];
        }

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('meal_book', array('id' => $meal->getId())))
            ->setMethod('POST')
            ->add('formula', 'choice', array(
                'choices' => $available_formulas,
                'label' => "Formule"))
            ->getForm()
        ;
    }
}
