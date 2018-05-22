<?php

namespace AppBundle\Repository;

use \Doctrine\ORM\EntityRepository;

class CurrencyRepository extends EntityRepository
{
    public function findByName($name = '')
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.name = :name')
            ->setParameter('name', $name)
            ->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

}
