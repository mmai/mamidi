<?php

namespace Mamidi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HostController extends Controller
{
    public function mealsAction($host)
    {
        $userManager = $this->get('fos_user.user_manager');
        $hostUser = $userManager->findUserBy(array('username' => $host));

        $isCurrentHost = false;
        $current_user = $this->container->get('security.context')->getToken()->getUser();
        if ($current_user != "anon."){
            $isCurrentHost =  ($current_user->getId() == $hostUser->getId());
        }

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MamidiClassifiedBundle:Meal')->findByHost($hostUser);

        return $this->render('MamidiUserBundle:Host:meals.html.twig', array(
            'host' => $hostUser,
            'isCurrentHost' => $isCurrentHost,
            'entities' => $entities,
            ));    }

}
