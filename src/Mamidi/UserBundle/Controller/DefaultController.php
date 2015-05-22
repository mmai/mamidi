<?php

namespace Mamidi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MamidiUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
