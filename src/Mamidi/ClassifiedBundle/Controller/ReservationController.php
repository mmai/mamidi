<?php

namespace Mamidi\ClassifiedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReservationController extends Controller
{
    public function indexAction()
    {
        return $this->render('MamidiClassifiedBundle:Reservation:index.html.twig', array(
                // ...
            ));    }

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

}
