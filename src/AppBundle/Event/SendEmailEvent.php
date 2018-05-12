<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
namespace AppBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class SendEmailEvent extends Event
{
	const NAME = 'app.send_email';

	protected $to;

	protected $data;

	protected $template;

	protected $from;

	/**
	 * SendEmailEvent constructor.
	 *
	 * @param string      $to       Email to send to
	 * @param array       $data
	 * @param string|null $template
	 */
	public function __construct($to, $data = [], $template = null, $from = null) {
		$this->to       = $to;
		$this->data     = $data;
		$this->template = $template;
		$this->from     = $from;
	}

	/**
	 * @return string
	 */
	public function getTo() {
		return $this->to;
	}

	/**
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @return string|null
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * @return null
	 */
	public function getFrom() {
		return $this->from;
	}
}