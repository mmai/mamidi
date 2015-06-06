<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $security_ctx = $this->container->get('security.context');
        $router = $this->container->get('router');
        if ($security_ctx->isGranted('ROLE_GUEST')){
            return new RedirectResponse($router->generate('meal', array()));
        } else if ($security_ctx->isGranted('ROLE_HOST')){
            return new RedirectResponse($router->generate('host_meals', array('host' => $security_ctx->getToken()->getUser())));
        }

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MamidiClassifiedBundle:Meal')->findAll();
        return $this->render('default/index.html.twig', array('entities' => $entities));
    }

    /**
     * @Route("/about/", name="about")
     */
    public function aboutAction()
    {
        return $this->render('default/about.html.twig');
    }
}
