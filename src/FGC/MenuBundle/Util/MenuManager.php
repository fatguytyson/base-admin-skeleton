<?php
namespace FGC\MenuBundle\Util;

use FGC\MenuBundle\Annotation\Menu;

class MenuManager
{
    /**
     * @var MenuDiscovery
     */
    private $menuDiscovery;

    /**
     * @var array
     */
    private $menus;

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
        if (!$this->menus) {
            $this->menus = $this->menuDiscovery->getMenus();
        }
        return $this->menus;
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
        $menus = $this->getMenus();
        if (isset($menus[$name])) {
            return $menus[$name];
        }
        throw new \Exception('Menu not found');
    }
}