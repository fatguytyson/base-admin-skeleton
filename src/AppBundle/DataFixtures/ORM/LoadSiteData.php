<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\SiteSettings;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSiteData implements FixtureInterface, ContainerAwareInterface
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
        $settings = [];

        $temp = new SiteSettings();
        $temp->setTitle('contact_form')->setValue(':sprites:contact_form.html.twig');
        $settings[] = $temp;

        $temp = new SiteSettings();
        $temp->setTitle('testimonials')->setValue(':sprites:testimonials.html.twig');
        $settings[] = $temp;

        $temp = new SiteSettings();
        $temp->setTitle('events')->setValue(':sprites:events.html.twig');
        $settings[] = $temp;

        foreach ($settings as $setting) {
            $manager->persist($setting);
        }
        $manager->flush();
    }
}