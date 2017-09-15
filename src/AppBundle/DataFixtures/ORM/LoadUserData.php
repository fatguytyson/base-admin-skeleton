<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Util\Canonicalizer;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Util\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $um = new UserManager(
            $this->container->get('security.encoder_factory'),
            $can = new Canonicalizer(),
            $can,
            $this->container->get('doctrine.orm.entity_manager'));
        $users = array();
        $temp = $um->createUser();
        $temp
            ->setUsername('fatguy')
            ->setEmail('tyson@fatguyconsulting.com')
            ->setPlainPassword('Gather!2')
            ->setEnabled(true)
            ->setRoles(['ROLE_SUPER_ADMIN']);

        $users[] = $temp;

        $temp = $um->createUser();
        $temp
            ->setUsername('nicole')
            ->setEmail('agreenoillife@gmail.com')
            ->setPlainPassword('0okM9ijn88')
            ->setEnabled(true)
            ->setRoles(['ROLE_ADMIN']);

        $users[] = $temp;

        foreach ($users as $user) {
            $um->updateUser($user, false);
        }
        $manager->flush();
    }
}