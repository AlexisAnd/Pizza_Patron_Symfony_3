<?php

namespace AppBundle\Repository;

/**
 * PizzasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PizzasRepository extends \Doctrine\ORM\EntityRepository
{

    public function getResults()
    {
        $results = $this->createQueryBuilder('pizzas')
            ->getQuery()
            ->getResult();

        return $results;
    }
}