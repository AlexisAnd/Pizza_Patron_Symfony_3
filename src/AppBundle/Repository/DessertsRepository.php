<?php

namespace AppBundle\Repository;

/**
 * DessertsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DessertsRepository extends \Doctrine\ORM\EntityRepository
{

    public function getResults()
    {

        $results = $this->createQueryBuilder('desserts')
            ->getQuery()
            ->getResult();

        return $results;
    }

}