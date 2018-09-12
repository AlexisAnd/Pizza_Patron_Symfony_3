<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 20/11/2017
 * Time: 16:28
 */

namespace AppBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;

class AuthentificationSubscriber implements EventSubscriberInterface
{

    private $session;

    public function __construct(SessionInterface $session) {

        $this->session = $session;
}

    public static function getSubscribedEvents() {

        return [
            AuthenticationEvents::AUTHENTICATION_FAILURE=>'failure'
        ];
    }

    public function failure() {

        if ($this->session->has('number_failures'))
        {
            $value = $this->session->get('number_failures');
            $value +=1;

            $this->session->set('number_failures', $value);

            //on fait le tableau et la redirection directement
            // dans le controller pour pouvoir faire un redirect

        }
        //si la cle n'existe pas
        else {
            $this->session->set('number_failures', 1);
        }
    }

}