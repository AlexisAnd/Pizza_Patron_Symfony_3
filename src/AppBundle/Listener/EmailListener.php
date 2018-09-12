<?php
/**
 * Created by PhpStorm.
 * User: wabap38
 * Date: 19/10/17
 * Time: 13:59
 */

namespace AppBundle\Listener;

use AppBundle\Createtoken\Creationtoken;
use AppBundle\Entity\Token;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class EmailListener
{
    private $tokenb;
    private $twig;
    private $mailer;

    public function __construct( \Swift_Mailer $mailer, \Twig_Environment $twig, Creationtoken $tokenb)
    {

        $this->tokenb = $tokenb;
        $this->twig = $twig;
        $this->mailer = $mailer;


    }

    public function prePersist(Token $token, LifecycleEventArgs $event)
    {
        $token2 = $this->tokenb->createToken(32);

        $token->setToken($token2);

    }

    public function postPersist(Token $token, LifecycleEventArgs $event) {

        $message = (new \Swift_Message())
            ->setFrom('contact@learning.com')
            ->setSubject('Votre compte')
            ->setTo($token->getEmail())
            ->setContentType('text/html')
            ->setbody(
                $this->twig->render('mailing/mailing_password_recovery.html.twig', [
                    'email'=> $token->getEmail(), 'token'=>$token->getToken()])

            )

        ;

        $this->mailer->send($message);
    }
}