<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 17/11/2017
 * Time: 17:11
 */

namespace AppBundle\Listener;


use AppBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserListener
{

    private $passwordEncoder;
    private $mail;
    private $twig;

    public function __construct(UserPasswordEncoder $passwordEncoder, \Swift_Mailer $mail, \Twig_Environment $twig)
{

    $this->passwordEncoder = $passwordEncoder;
    $this->mail = $mail;
    $this->twig = $twig;
}

    public function prePersist(User $user, LifecycleEventArgs $event) {

        $password = $user->getPassword();
        $passwordEncoded = $this->passwordEncoder->encodePassword($user, $password);
        $user->setPassword($passwordEncoded);

    }


    public function preUpdate(User $user, LifecycleEventArgs $event) {

        $password = $user->getPassword();
        $passwordEncoded = $this->passwordEncoder->encodePassword($user, $password);
        $user->setPassword($passwordEncoded);

    }
    public function postPersist(User $user, LifecycleEventArgs $event)
    {
        $message = (new \Swift_Message())
            ->setFrom('contact@learning.com')
            ->setSubject('Bienvenue')
            //pour recuperer l'adresse email du client
            ->setTo($user->getUsername())
            ->setContentType('text/html')
//            #si le format est html
//            ->setBody($this->twig->render('mailing/mail.html.twig', [
//                'email'=> $user->getEmail(), 'name'=>$user->getUsername()

            #si le format d'email est texte:
//            ->setBody($this->twig->render('mailing/mail.text.twig', [
//                'email'=> $user->getEmail(), 'name'=>$user->getUsername()])
//            )
            #pour l'envoyer aux deux formats en même temps:

            ->addPart(
                $this->twig->render('mailing/mailregister.txt.twig', [
                    'email' => $user->getUsername(), 'name' => $user->getFirstName()])
                , 'text/plain'
            );

        $this->mail->send($message);
    }

    }