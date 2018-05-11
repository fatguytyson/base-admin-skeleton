<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
namespace AppBundle\Util;


use AppBundle\Entity\Job;

interface JobManagerInterface
{
	/**
	 * Finds a job by email key
	 *
	 * @param string $apikey
	 *
	 * @return Job
	 */
	public function findJobByKey($apikey);

	/**
	 * @return string
	 */
	public function getClass();

}