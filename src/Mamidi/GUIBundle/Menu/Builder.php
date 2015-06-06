<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 25/05/15
 * Time: 16:00
 */

namespace Mamidi\GUIBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $securityContext = $this->container->get('security.context');

        $menu = $factory->createItem('root');

        /* findMostRecent and Blog are just imaginary examples
        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();

        $menu->addChild('Latest Blog Post', array(
            'route' => 'blog_show',
            'routeParameters' => array('id' => $blog->getId())
        ));
        */

        if ($securityContext->isGranted('ROLE_HOST')) {
            $user = $securityContext->getToken()->getUser();
            $menu->addChild('Mes repas', array(
                'route' => 'host_meals',
                'routeParameters' => array('host' => $user->getUserName())
            ));
            $menu->addChild('Reservations', array(
                'route' => 'host_reservations'
            ));
        } else if ($securityContext->isGranted('ROLE_GUEST')) {
            $user = $securityContext->getToken()->getUser();
            $menu->addChild('Trouver un repas', array(
                'route' => 'meal'
            ));
            $menu->addChild('Mes réservations', array(
                'route' => 'guest_reservations'
            ));
        } else {
            $menu->addChild('Accueil', array('route' => 'homepage'));
        }

        return $menu;
    }

    public function loginMenu(FactoryInterface $factory, array $options)
    {
        $securityContext = $this->container->get('security.context');
        $menu = $factory->createItem('root');

        $translator = $this->container->get('translator');
        if ($securityContext->isGranted("IS_AUTHENTICATED_REMEMBERED")){
            $user = $securityContext->getToken()->getUser();
            //$message =  $translator->trans('layout.logged_in_as', array('%username%' => $user->getUserName())); //FosUserBundle
            $message =  $translator->trans('Connecté en tant que %username%', array('%username%' => $user->getUserName()));
            $menu->addChild($message);

            //$logout_message = $translator->trans('layout.logout'); //FosUserBundle
            $logout_message = $translator->trans('Déconnexion'); //FosUserBundle
            $menu[$message]->addChild($logout_message, array('route' => "fos_user_security_logout"));
        }
        else {
            //$login_message = $translator->trans('layout.login'); //FosUserBundle
            $login_message = $translator->trans('Connexion');
            $menu->addChild($login_message, array('route' => "fos_user_security_login"));
        }

        return $menu;
    }
}