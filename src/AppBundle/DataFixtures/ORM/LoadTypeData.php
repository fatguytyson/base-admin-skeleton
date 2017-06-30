<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\CategoryType;
use AppBundle\Entity\EntryType;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadTypeData implements FixtureInterface, ContainerAwareInterface
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
        $entities = [];

        $entities[] = new CategoryType('PersonCount',5);
        $entities[] = new CategoryType('PhraseCount',6);
        $entities[] = new CategoryType('Phrase',2);
        $entities[] = new CategoryType('PersonPhrase',3);
        $entities[] = new EntryType('person');
        $entities[] = new EntryType('phrase');

        foreach ($entities as $entity) {
            $manager->persist($entity);
        }
        $manager->flush();
    }
}