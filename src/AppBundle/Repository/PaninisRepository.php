<?php

namespace AppBundle\Repository;

/**
 * PaninisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaninisRepository extends \Doctrine\ORM\EntityRepository
{

    public function getResults()
    {

        $results = $this->createQueryBuilder('paninis')
            ->getQuery()
            ->getResult();

        return $results;
    }

}
