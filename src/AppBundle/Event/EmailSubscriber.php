<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
namespace AppBundle\Event;


use AppBundle\Util\MailGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EmailSubscriber implements EventSubscriberInterface
{
	protected $mg;

	protected $mailer;

	public function __construct(MailGenerator $mail_generator, \Swift_Mailer $mailer)
	{
		$this->mg = $mail_generator;
		$this->mailer = $mailer;
	}

	public static function getSubscribedEvents()
	{
		return [SendEmailEvent::NAME => 'onSendEmail'];
	}

	public function onSendEmail(SendEmailEvent $event)
	{
		$email = $this->mg->getMessage($event->getTemplate(), $event->getData());
		$email->setTo($event->getTo());
		if ($from = $event->getFrom()) {
			$email->setFrom($from)->setSender($from);
		}
		$this->mailer->send($email);
	}
}