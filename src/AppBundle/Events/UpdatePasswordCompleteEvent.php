<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 21/11/2017
 * Time: 15:35
 */

namespace AppBundle\Events;


use Symfony\Component\EventDispatcher\Event;

class UpdatePasswordCompleteEvent extends Event
{

    private $email;
    private $token;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

}