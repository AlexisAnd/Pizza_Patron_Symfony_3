<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Orderline;
use AppBundle\Entity\Orders;
use AppBundle\Entity\Paninis;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app.default.index")
     */
    public function indexAction(Request $request)
    {

        return $this->render('default/index.html.twig',[]);

    }

}
