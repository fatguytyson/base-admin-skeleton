<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Season;
use Doctrine\ORM\Query\Expr;

/**
 * CategoryTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryTypeRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSeasonData(Season $season) {
        $qb = $this->createQueryBuilder('category_type')
//            ->join('category_type.categories', 'categories')
//            ->addSelect('categories')
            ->join('category_type.ste', 'ste')
            ->addSelect('ste')
            ->join('ste.entry', 'entry')
            ->addSelect('entry')
            ->join('ste.csd', 'csd')
            ->addSelect('csd')
            ->join('csd.category', 'category')
            ->addSelect('category')
            ->where('ste.season = :season')
            ->setParameter('season', $season);
        return $qb->getQuery()->getResult();
    }
}