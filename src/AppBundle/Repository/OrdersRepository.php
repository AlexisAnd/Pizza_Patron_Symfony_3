<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Orders;

/**
 * OrdersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdersRepository extends \Doctrine\ORM\EntityRepository
{

    public function getOrderId($userId)
    {
        $results = $this->createQueryBuilder('orders')
            ->select('orders.id')
            ->where('orders.userId = :id')
            ->andWhere('orders.completeTimeStamp is Null')
            ->setParameters([
                'id'=> $userId
            ])
            ->getQuery()
            ->getOneOrNullResult();

        return $results;
    }

    public function completeOrder($orderId, $total, $dateTime)
    {
        $results = $this->getEntityManager()->createQueryBuilder()
            ->update('AppBundle:Orders', 'orders')
            ->set('orders.completeTimeStamp', ':complete')
            ->set('orders.total', ':total')
            ->where('orders.id = :id')
            ->setParameters([
                'id'=> $orderId,
                'complete'=> $dateTime,
                'total'=>$total
            ])
            ->getQuery()
            ->execute();

        return $results;
    }


    public function getOrdersList($userId)
    {
        $results = $this->createQueryBuilder('orders')
            ->where('orders.userId = :id')
            ->andWhere('orders.completeTimeStamp is not Null')
            ->setParameters([
                'id'=> $userId
            ])
            ->getQuery()
            ->getResult();

        return $results;
    }

    public function getOrderDetails($id)
    {
        $results = $this->createQueryBuilder('orders')
            ->where('orders.id = :id')
            ->setParameters([
                'id'=> $id
            ])
            ->getQuery()
            ->getOneOrNullResult();

        return $results;
    }

}