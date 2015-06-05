<?php

namespace Mamidi\ClassifiedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;

use Mamidi\ClassifiedBundle\Entity\Meal;
use Mamidi\ClassifiedBundle\Entity\Reservation;

/**
 * @Security("is_authenticated()")
 */
class ReservationController extends Controller
{
    public function indexAction()
    {
        $current_user = $this->container->get('security.context')->getToken()->getUser();
        if ($current_user->hasRole('ROLE_GUEST')) {
            return $this->guestReservationsAction($current_user);
        } else {
            return $this->hostReservationsAction($current_user);
        }
    }

    private function guestReservationsAction($current_user){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MamidiClassifiedBundle:Reservation')->findBy(array(
            'guest' => $current_user
        ));

        return $this->render('MamidiClassifiedBundle:Reservation:index.html.twig', array(
            'entities' => $entities,
            'guest' => $current_user
            ));
    }

    private function hostReservationsAction($current_user){
        $em = $this->getDoctrine()->getManager();
        $meals = $em->getRepository('MamidiClassifiedBundle:Meal')->findBy(array(
            'host' => $current_user
        ));
        return $this->render('MamidiClassifiedBundle:Reservation:index_host.html.twig', array(
            'meals' => $meals,
            'host' => $current_user
        ));
    }

    /**
     * Accept a Reservation request
     *
     * @Route("/reservation/{id}/accept", name="reservation_accept")
     * @Method("POST")
     * @Security("has_role('ROLE_HOST')")
     *
     */
    public function acceptAction(Request $request, Reservation $reservation)
    {
        $form = $this->createAcceptForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setStatus("ACCEPTED");
            //TODO Do this in a service with events
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $session = new Session();
            $session->getFlashBag()->add(
                'success',
                'La réservation a été acceptée'
            );
        }

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }


    /**
     * @Route("/reservation/{id}/accept_form", name="reservation_accept_form")
     * @Method("POST")
     *
     */
    public function accept_formAction(Reservation $id)
    {
        $form = $this->createAcceptForm($id);
        return $this->render("@MamidiClassified/Reservation/reservation_accept_form.html.twig", array("form" => $form->createView()));
    }

    /**
     * Creates a form to accept a Reservation for a Meal
     *
     * @param Reservation $reservation
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAcceptForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_accept', array('id' => $reservation->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }


    /**
     * Reject a Reservation request
     *
     * @Route("/reservation/{id}/reject", name="reservation_reject")
     * @Method("POST")
     * @Security("has_role('ROLE_HOST')")
     *
     */
    public function rejectAction(Request $request, Reservation $reservation)
    {
        $form = $this->createRejectForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO Do this in a service with events
            $reservation->setStatus("REJECTED");
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $session = new Session();
            $session->getFlashBag()->add(
                'success',
                'La réservation a été rejetée'
            );
        }

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }


    /**
     * @Route("/reservation/{id}/reject_form", name="reservation_reject_form")
     * @Method("POST")
     *
     */
    public function reject_formAction(Reservation $id)
    {
        $form = $this->createRejectForm($id);
        return $this->render("@MamidiClassified/Reservation/reservation_reject_form.html.twig", array("form" => $form->createView()));
    }

    /**
     * Creates a form to reject a Reservation for a Meal
     *
     * @param Reservation $reservation
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRejectForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_reject', array('id' => $reservation->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }

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

            //TODO Do this in a service with events
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();

            $session = new Session();
            $session->getFlashBag()->add(
                'success',
                'La réservation a été annulée'
            );
        }

        return $this->redirect($this->getRequest()->headers->get('referer'));
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
