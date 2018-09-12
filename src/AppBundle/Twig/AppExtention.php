<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 22/11/2017
 * Time: 14:01
 */

namespace AppBundle\Twig;


use AppBundle\Entity\Desserts;
use AppBundle\Entity\Drinks;
use AppBundle\Entity\Paninis;
use AppBundle\Entity\Pizza;
use AppBundle\Entity\Pizza_big;
use AppBundle\Entity\Pizza_medium;
use AppBundle\Entity\Pizzas;
use AppBundle\Entity\Texmex;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class AppExtention extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    private $doctrine;
    private $twig;
    private $request;

    /*
     * Injections de services dans la classe
     */
    public function __construct(ManagerRegistry $doctrine,\Twig_Environment $twig, RequestStack $request) {

        $this->doctrine = $doctrine;
        $this->twig = $twig;

        $this->request = $request->getMasterRequest();
    }

    public function getFunctions()
    {

        return [

            new \Twig_SimpleFunction('render_drinks', [$this, 'renderDrinks']),
            new \Twig_SimpleFunction('render_desserts', [$this, 'renderDesserts']),
            new \Twig_SimpleFunction('render_paninis', [$this, 'renderPaninis']),
            new \Twig_SimpleFunction('render_texmex', [$this, 'renderTexmex']),
            new \Twig_SimpleFunction('render_pizzas', [$this, 'renderPizzas']),

        ];
    }

    public function renderDrinks() {


        $results = $this->doctrine->getRepository(Drinks::class)->getResults();


        return $this->twig->render('inc/render_drinks.html.twig', ['results'=>$results]);

    }
    public function renderDesserts() {


        $results = $this->doctrine->getRepository(Desserts::class)->getResults();


        return $this->twig->render('inc/render_desserts.html.twig', ['results'=>$results]);

    }
    public function renderPaninis() {


        $results = $this->doctrine->getRepository(Paninis::class)->getResults();


        return $this->twig->render('inc/render_paninis.html.twig', ['results'=>$results]);

    }
    public function renderTexmex() {


        $results = $this->doctrine->getRepository(Texmex::class)->getResults();


        return $this->twig->render('inc/render_texmex.html.twig', ['results'=>$results]);

    }
    public function renderPizzas() {

        $results = $this->doctrine->getRepository(Pizzas::class)->getResults();


        return $this->twig->render('inc/render_pizzas.html.twig', ['results'=>$results]);

    }

}