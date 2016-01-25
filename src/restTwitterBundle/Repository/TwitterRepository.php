<?php

namespace restTwitterBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TwitterRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TwitterRepository extends EntityRepository
{
    public function findPost($limit)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('t')
            ->from('restTwitterBundle\Entity\Twitter', 't')
            ->orderBy('t.date','DESC')
            ->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }

}