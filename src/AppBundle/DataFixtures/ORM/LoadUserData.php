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
            ->setUsername('admin')
            ->setEmail('admin@site.com')
            ->setPlainPassword('password')
            ->setEnabled(true)
            ->setRoles(['ROLE_SUPER_ADMIN']);

        $users[] = $temp;

        foreach ($users as $user) {
            $um->updateUser($user, false);
        }
        $manager->flush();
    }
}