<?php
/**
 * Created by PhpStorm.
 * User: wabap38
 * Date: 18/10/17
 * Time: 14:31
 */

namespace AppBundle\Createtoken;

class Creationtoken
{

    public function createToken(int $length)
    {
        $value = bin2hex(random_bytes($length/2));

        return $value;
    }
}