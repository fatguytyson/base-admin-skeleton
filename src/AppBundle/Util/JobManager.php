<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
namespace AppBundle\Util;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class JobManager implements JobManagerInterface
{
	/**
	 * @var EntityManagerInterface
	 */
	protected $em;

	/**
	 * @var EntityRepository
	 */
	protected $repo;

	/**
	 * @var string
	 */
	protected $class;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
		$this->repo = $this->em->getRepository('AppBundle:Job');

		$this->class = 'AppBundle\\Entity\\Job';
	}

	public function findJobByKey( $apikey ) {
		return $this->repo->findOneBy(['key' => $apikey]);
	}

	public function getClass() {
		return $this->class;
	}
}