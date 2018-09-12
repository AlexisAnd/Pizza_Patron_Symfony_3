<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 06/12/2017
 * Time: 11:09
 */

namespace AppBundle\Controller\Profiles;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/profiles")
 */
class UserSettingsController extends Controller
{

    /**
     * @Route("/usersettings", name="app.profiles.usersettings")
     */
    public function userSettingsAction() {

        Return $this->render('profiles/usersettings.html.twig');
    }
}