<?php

namespace Mamidi\ClassifiedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Mamidi\ClassifiedBundle\Entity\Meal;

class ReservationController extends Controller
{
    public function indexAction()
    {
        $current_user = $this->container->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MamidiClassifiedBundle:Reservation')->findBy(array(
            'guest' => $current_user
        ));

        return $this->render('MamidiClassifiedBundle:Reservation:index.html.twig', array(
            'entities' => $entities,
            'guest' => $current_user
            ));
    }

    public function acceptAction()
    {
        return $this->render('MamidiClassifiedBundle:Reservation:accept.html.twig', array(
                // ...
            ));    }

    public function rejectAction()
    {
        return $this->render('MamidiClassifiedBundle:Reservation:reject.html.twig', array(
                // ...
            ));    }

    /**
     * Cancel a Reservation for this meal
     *
     * @Route("/meal/{id}/book_cancel", name="reservation_cancel")
     * @Method("POST")
     * @Security("has_role('ROLE_GUEST')")
     *
     */
    public function cancelAction(Request $request, Meal $meal)
    {
        $form = $this->createCancelForm($meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $this->getDoctrine()->getRepository('MamidiClassifiedBundle:Reservation')->findOneBy(array(
                'guest' => $this->getUser(),
                'meal' => $meal
            ));

            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('meal');
    }

    /**
     * @Route("/meal/{id}/cancel_form", name="reservation_cancel_form")
     * @Method("POST")
     *
     */
    public function cancel_formAction(Meal $id)
    {
        $form = $this->createCancelForm($id);
        return $this->render("@MamidiClassified/Reservation/reservation_cancel_form.html.twig", array("form" => $form->createView()));
    }

    /**
     * Creates a form to add a Reservation for a Meal
     *
     * @param Meal $meal The meal object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCancelForm(Meal $meal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_cancel', array('id' => $meal->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }
}
