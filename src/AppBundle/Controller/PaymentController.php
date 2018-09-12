<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 01/12/2017
 * Time: 12:07
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Orderline;
use AppBundle\Entity\Orders;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaymentController extends Controller
{

    /**
     * @Route("/payment", name="app.payment.payment")
     */
    public function paymentAction() {

        $user = $this->getUser();
        $userId = $user->getId();

        $doctrine = $this->getDoctrine();

        $result = $doctrine->getRepository(Orders::class)->getOrderId($userId);
        $orderid = $result['id'];

        $getList = $doctrine->getRepository(Orderline::class)->getList($orderid);

        $getTotal = $doctrine->getRepository(Orderline::class)->getTotal($orderid);

        return $this->render('payment/payment.html.twig',['getlist'=>$getList, 'gettotal'=>$getTotal, 'orderId'=>$orderid]);
    }

    /**
     * @Route("/validation", name="app.payment.validation")
     */
    public function validationAction(){
        $user = $this->getUser();
        $userId = $user->getId();
        $dateTime = new \DateTime('now');

        $doctrine = $this->getDoctrine();

        $result = $doctrine->getRepository(Orders::class)->getOrderId($userId);
        $orderId = $result['id'];

        $total = $doctrine->getRepository(Orderline::class)->getTotal($orderId);

        $doctrine->getRepository(Orders::class)->completeOrder($orderId, $total, $dateTime);


        return $this->render('payment/validation.html.twig',[]);
    }
}