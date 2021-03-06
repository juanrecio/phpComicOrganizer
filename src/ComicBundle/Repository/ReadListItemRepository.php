<?php

namespace ComicBundle\Repository;

use \Doctrine\ORM\EntityRepository;

/**
 * ReadListItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReadListItemRepository extends EntityRepository
{
    /**
     * @param array $filters
     * @return array
     */
    public function listReadListItems(array $filters = [])
    {
        $alias = 'rli';
        $qb = $this->createQueryBuilder($alias)->select($alias);

        if (isset($filters['readList'])) {

            $aliasReadList = 'rl';
            $qb->join("$alias.readList", "$aliasReadList")
                ->andWhere($qb->expr()->eq("$aliasReadList.id", ':readList'))
                ->setParameter('readList', $filters['readList']);
        }


        return $qb->getQuery()->getResult();
    }
}
