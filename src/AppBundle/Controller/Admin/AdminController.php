<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 16/11/2017
 * Time: 17:33
 */

namespace AppBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="app.admin.admin")
     *
     */
    public function adminAction()
    {

        return $this->render('admin/admin.html.twig', []);

    }
}