<?php

namespace AppBundle\Repository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
	public function findUpcoming() {
		return $this->createQueryBuilder('e')
			->where('e.date >= :today')
			->setParameter('today', new \DateTime())
			->orderBy('e.date', 'ASC')
			->getQuery()
			->getResult()
			;
	}
}
