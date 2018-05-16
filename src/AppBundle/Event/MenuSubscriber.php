<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace AppBundle\Event;

use FGC\MenuBundle\Annotation\Menu;
use FGC\MenuBundle\Event\DiscoverMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MenuSubscriber implements EventSubscriberInterface
{
	protected $user;

	public function __construct(TokenStorageInterface $token) {
		$token = $token->getToken();
		$this->user = $token ? $token->getUser() : null;
	}

	public static function getSubscribedEvents() {
		return array(
			DiscoverMenuEvent::NAME => 'onDiscoverMenu'
		);
	}

	public function onDiscoverMenu(DiscoverMenuEvent $event) {
//		$menu = new Menu();
//		$menu->setGroup('user');
//		$menu->setName('Dynamic Menu Item');
//		$event->addMenuItem($menu); // Add all the menu items you want.
	}

}