<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 20/11/2017
 * Time: 12:47
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AboutController extends Controller
{

    /**
     * @Route("/history", name="app.about.history")
     */
    public function historyAction(){


        return $this->render('about/history.html.twig',[]);
    }

    /**
     * @Route("/contact", name="app.about.contact")
     */
    public function productsAction() {

        return $this->render('about/contact.html.twig',[]);
    }
}