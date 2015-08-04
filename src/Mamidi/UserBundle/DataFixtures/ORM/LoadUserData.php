<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 04/08/15
 * Time: 12:40
 */

namespace Mamidi\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mamidi\UserBundle\Entity\HostUser;

class LoadUserData implements FixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $mamie = new HostUser();
        $mamie->setUsername('mamie');
        $mamie->setPlainPassword('mamie');
        $mamie->setEnabled(true);
        $mamie->setRoles(array('ROLE_HOST'));
        $mamie->setEmail('mamie@mamie.org');
        $mamie->setFirstname("Odette");
        $mamie->setLastname("Martin");
        $mamie->setAddress("8 rue de la Garenne");
        $mamie->setCity("Bordeaux");
        $mamie->setZip("33000");

        $manager->persist($mamie);
        $manager->flush();
    }
}