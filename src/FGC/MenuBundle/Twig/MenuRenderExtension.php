<?php
namespace FGC\MenuBundle\Twig;

use FGC\MenuBundle\Util\MenuRender;

class MenuRenderExtension extends \Twig_Extension
{
    /**
     * @var MenuRender
     */
    private $menuRender;

    public function __construct(MenuRender $menuRender)
    {
        $this->menuRender = $menuRender;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('fgc_menu', array($this,'FGCMenuRender'), array('is_safe' => array('html')))
        );
    }

    public function FGCMenuRender($name = 'default', $template = 'default', $depth = 2)
    {
        return $this->menuRender->FGCMenuRender($name, $template, $depth);
    }
}