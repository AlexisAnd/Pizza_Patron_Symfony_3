<?php

namespace AppBundle\Repository;

/**
 * OrderlineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderlineRepository extends \Doctrine\ORM\EntityRepository
{

    public function getQuantity($pizzaid, $paniniid, $texmexid, $dessertid, $drinkid, $orderid, $price)
    {
        $results = $this->createQueryBuilder('orderline')
            ->select('orderline.quantity')
            ->Where('orderline.orderId = :order')
            ->andWhere('orderline.price = :price')
            ->andwhere('orderline.pizzaId = :pizza')
            ->orwhere('orderline.paninisId = :panini')
            ->orWhere('orderline.texmexId = :texmex')
            ->orWhere('orderline.dessertsId = :dessert')
            ->orWhere('orderline.drinksId = :drink')
            ->setParameters([
                'order'=>$orderid,
                'price'=>$price,
                'pizza'=> $pizzaid,
                'panini'=> $paniniid,
                'texmex'=> $texmexid,
                'dessert'=> $dessertid,
                'drink'=> $drinkid
            ])
            ->getQuery()
            ->getOneOrNullResult();

        return $results;
    }

    public function getList($orderid)
    {
        $results = $this->createQueryBuilder('orderline')
            ->Where('orderline.orderId = :order')
            ->setParameters([
                'order'=>$orderid,
            ])
            ->getQuery()
            ->getResult();

        return $results;
    }

    public function getTotal($orderid)
    {
        $results = $this->createQueryBuilder('orderline')
            ->select("SUM(orderline.price * orderline.quantity) as total")
            ->Where('orderline.orderId = :order')
            ->setParameters([
                'order'=>$orderid,
            ])
            ->groupBy('orderline.orderId')
            ->getQuery()
            ->getOneOrNullResult();

        return $results;
    }


}
