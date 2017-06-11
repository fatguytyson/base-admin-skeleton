<?php

namespace AppBundle\Util;


class MenuManager
{
    /**
     * @var MenuDiscovery
     */
    private $menuDiscovery;

    /**
     * MenuManager constructor.
     * @param MenuDiscovery $menuDiscovery
     */
    public function __construct(MenuDiscovery $menuDiscovery)
    {
        $this->menuDiscovery = $menuDiscovery;
    }

    /**
     * Return all menus
     *
     * @return array
     */
    public function getMenus()
    {
        return $this->menuDiscovery->getMenus();
    }

    /**
     * Get specific menu
     *
     * @param $name string
     * @return array
     * @throws \Exception
     */
    public function getMenu($name)
    {
        $menu = $this->getMenus();
        if (isset($menu[$name])) {
            return $menu[$name];
        }
        throw new \Exception('Menu not found');
    }
}