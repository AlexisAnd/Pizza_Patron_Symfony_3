<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 24/11/2017
 * Time: 17:44
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Orderline;
use AppBundle\Entity\Orders;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends Controller
{
    /**
     * @Route("/addtocart", name="app.orders.addtocart")
     */
    public function addToCart(Request $request) {

        $user = $this->getUser();
        $userId = $user->getId();
        $address = $user->getAddress();
        $city = $user->getCity();
        $postalcode = $user->getPostalCode();
        $phone = $user->getPhone();
        $dateTime = new \DateTime('now');

        $doctrine = $this->getDoctrine();
        $results = $doctrine->getRepository(Orders::class)->findOneBy([
            'userId'=>$userId,
            'completeTimeStamp'=> NULL,
        ]);

        if(!$results) {
            $em = $this->getDoctrine()->getManager();
            $order = new Orders();
            $order->setUserId($userId);
            $order->setAddress($address);
            $order->setCity($city);
            $order->setPostalCode($postalcode);
            $order->setPhone($phone);
            $order->setCreationTimeStamp($dateTime);
            $em->persist($order);
            $em->flush();
        }


        $pizzaid = $request->get('pizzaid');
        $paniniid = $request->get('paniniid');
        $texmexid = $request->get('texmexid');
        $dessertid = $request->get('dessertid');
        $drinkid = $request->get('drinkid');
        $name = $request->get('name');
        $price = $request->get('price');
        $quantity = $request->get('quantity');

        $doctrine = $this->getDoctrine();
        $result = $doctrine->getRepository(Orders::class)->getOrderId($userId);
        $orderid = $result['id'];


        $resultQuantity = $doctrine->getRepository(Orderline::class)->findOneBy([
            'pizzaId'=>$pizzaid,
            'paninisId'=>$paniniid,
            'texmexId'=>$texmexid,
            'drinksId'=>$drinkid,
            'dessertsId'=>$dessertid,
            'orderId'=>$orderid,
            'price'=>$price,
        ]);


        if(!$resultQuantity) {
            $em = $this->getDoctrine()->getManager();
            $orderline = new Orderline();
            $orderline->setName($name);
            $orderline->setPizzaId($pizzaid);
            $orderline->setPaninisId($paniniid);
            $orderline->setTexmexId($texmexid);
            $orderline->setDrinksId($drinkid);
            $orderline->setDessertsId($dessertid);
            $orderline->setPrice($price);
            $orderline->setQuantity($quantity);
            $orderline->setOrderId($orderid);
            $orderline->setUserId($userId);
            $em->persist($orderline);
            $em->flush();
        }
            else {
                $em = $this->getDoctrine()->getManager();
                $lol = $doctrine->getRepository(Orderline::class)->getquantity
                ($pizzaid, $paniniid, $texmexid, $dessertid, $drinkid, $orderid, $price);
                $resultQuantity->setQuantity($lol['quantity'] + $quantity);
                $em->flush();
            }
        $getList = $doctrine->getRepository(Orderline::class)->getList($orderid);

        $getTotal = $doctrine->getRepository(Orderline::class)->getTotal($orderid);


        return $this->render('inc/basket.html.twig', ['getlist'=>$getList, 'gettotal'=>$getTotal]);

        }

    /**
     * @Route("/getcart", name="app.orders.getcart")
     */
       public function getCart() {

           $user = $this->getUser();
           $userId = $user->getId();

           $doctrine = $this->getDoctrine();

           $result = $doctrine->getRepository(Orders::class)->getOrderId($userId);
           $orderid = $result['id'];


           $getTotal = $doctrine->getRepository(Orderline::class)->getTotal($orderid);

           return $this->render('inc/cart.html.twig',['gettotal'=>$getTotal]);

       }


        /**
         * @Route("/deleteitem", name="app.orders.deleteitem")
         */
        public function deleteItem(Request $request){

            $id = $request->get('itemid');

            $doctrine = $this->getDoctrine();
            $getQuantity = $doctrine->getRepository(Orderline::class)->findOneBy([
                'id'=>$id
            ]);

            $quantity = $getQuantity->getQuantity();
            $em = $this->getDoctrine()->getManager();

            if($quantity == 1) {

                $em->remove($getQuantity);
                $em->flush();
            }
            else{
                $getQuantity->setQuantity($quantity -1);
                $em->flush();
            }

            $user = $this->getUser();
            $userId = $user->getId();

            $result = $doctrine->getRepository(Orders::class)->getOrderId($userId);
            $orderid = $result['id'];

            $getList = $doctrine->getRepository(Orderline::class)->getList($orderid);

            $getTotal = $doctrine->getRepository(Orderline::class)->getTotal($orderid);

            return $this->render('inc/basket.html.twig', ['getquantity'=>$getQuantity, 'getlist'=>$getList, 'gettotal'=>$getTotal]);

        }

    /**
     * @route("/orderslist", name="app.account.orders")
     */
        public function OrdersList() {

            $user = $this->getUser();
            $userId = $user->getId();

            $doctrine = $this->getDoctrine();

            $results = $doctrine->getRepository(Orders::class)->getOrdersList($userId);

//            exit(dump($results));

            return $this->render('account/orders.html.twig',['results'=>$results]);
        }

    /**
     * @route("/orderdetails/{id}", name="app.account.orderdetails")
     */
    public function OrderDeatils($id) {

        $doctrine = $this->getDoctrine();

        $results = $doctrine->getRepository(Orders::class)->getOrderDetails($id);


        return $this->render('account/orderdetails.html.twig',['results'=>$results]);
    }

}