<?php

namespace FGC\MenuBundle\Util;

use FGC\MenuBundle\Annotation\Menu;
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

    private $fetched;

    /**
     * MenuDiscovery constructor.
     * @param $rootDir
     * @param Reader $annotationReader
     * @param array $options
     */
    public function __construct($rootDir, Reader $annotationReader, $options)
    {
        $this->fetched = false;
        $this->annotationReader = $annotationReader;
        $this->rootDir = $rootDir;
        $this->directory = $options['directory'];
        $this->namespace = $options['namespace'];

        foreach ($options['menus'] as $group => $items) {
            foreach ($items as $name => $values) {
                $values['name']  = $name;
                $values['group'] = $group;
                $item = new Menu($values);
                if (isset($this->menus[$group])) {
                    $this->menus[$group][] = $item;
                } else {
                    $this->menus[$group] = array($item);
                }
            }
        }

    }

    /**
     * Returns all menus
     *
     * @return array
     */
    public function getMenus()
    {
        if (!$this->directory || !$this->namespace) {
            throw new \InvalidArgumentException('Directory/Namespace not set correctly.');
        }

        if (!$this->fetched) {
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
                            $this->menus[$ann->getGroup()] = array($ann);
                        }
                    }
                }
            }
        }

        foreach ($this->menus as &$group) {
            usort($group, function ($a, $b) {return $a->getOrder()<=$b->getOrder()?-1:1;});
        }

        $this->fetched = true;
    }
}