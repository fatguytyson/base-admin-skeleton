<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Util\UserManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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
        $um = $this->container->get(UserManager::class);
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