<?php

namespace AppBundle\Util;

use AppBundle\Annotation\Menu;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class MenuDiscovery
{
    private $namespace;

    private $directory;

    private $annotationReader;

    private $rootDir;

    private $menus;

    /**
     * MenuDiscovery constructor.
     * @param $namespace
     * @param $directory
     * @param $rootDir
     * @param Reader $annotationReader
     */
    public function __construct($namespace, $directory, $rootDir, Reader $annotationReader)
    {
        $this->namespace = $namespace;
        $this->annotationReader = $annotationReader;
        $this->directory = $directory;
        $this->rootDir = $rootDir;
    }

    /**
     * Returns all menus
     *
     * @return array
     */
    public function getMenus()
    {
        if (!$this->menus) {
            $this->discoverMenus();
        }

        return $this->menus;
    }

    /**
     * Gathers Annotation information for menus
     */
    private function discoverMenus()
    {
        $path = $this->rootDir . '/../src/' . $this->directory;
        $finder = new Finder();
        $finder->files()->in($path);

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $class = $this->namespace . '\\' . $file->getBasename('.php');
            foreach (get_class_methods($class) as $method) {
                $annotation = $this->annotationReader->getMethodAnnotations(new \ReflectionMethod("$class::$method"));
                /** @var Menu $ann */
                foreach ($annotation as $ann) {
                    if ($ann instanceof Menu) {
                        if (isset($this->menus[$ann->getGroup()])) {
                            $this->menus[$ann->getGroup()][] = $ann;
                        } else {
                            $this->menus[$ann->getGroup()] = [$ann];
                        }
                    }
                }
            }
        }

        foreach ($this->menus as &$group) {
            usort($group, function ($a, $b) {return $a->getOrder()<$b->getOrder()?-1:1;});
        }
    }
}