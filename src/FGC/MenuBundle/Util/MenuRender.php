<?php
namespace FGC\MenuBundle\Util;

use Symfony\Bridge\Twig\TwigEngine;

class MenuRender
{
    /**
     * @var \Twig_Environment $twigEngine
     */
    private $twigEngine;

    /**
     * @var MenuManager $menuManager
     */
    private $menuManager;

    public function __construct(MenuManager $menuManager, \Twig_Environment $twigEngine)
    {
        $this->twigEngine = $twigEngine;
        $this->menuManager = $menuManager;
    }

    public function FGCMenuRender($name = 'default', $template = 'default', $depth = 2)
    {
        return $this->twigEngine->render('@FGCMenu/'.$template.'.html.twig', array(
            'menu' => $this->menuManager->getMenu($name),
            'template' => $template,
            'depth' => --$depth
        ));
    }
}