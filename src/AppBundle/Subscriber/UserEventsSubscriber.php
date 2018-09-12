<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 21/11/2017
 * Time: 15:46
 */

namespace AppBundle\Subscriber;


use AppBundle\Entity\Token;
use AppBundle\Events\UpdatePasswordCompleteEvent;
use AppBundle\Events\UserEvent;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventsSubscriber implements EventSubscriberInterface
{

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine){

        $this->doctrine = $doctrine;
    }

    //comme dans js avec un addeventlistener. lance la fonction.
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.

        return [

            UserEvent::UPDATE_PASSWORD_COMPLETE => 'updatePasswordComplete',

        ];
    }

    // recoit en paramètre l'obljet lié à l'evenement écouté.
    public function updatePasswordComplete(UpdatePasswordCompleteEvent $event)
    {
        $this->doctrine->getRepository(Token::class)->deleteToken(
            $event->getEmail(),
            $event->getToken()
        );
    }

}