<?php
/**
 * Created by PhpStorm.
 * User: user1
 * Date: 20.11.2015
 * Time: 11:25
 */

namespace Application;


class Mailer
{
    /**
     * @param $email
     * @param $subject
     * @param $body
     * @return bool
     */
    public function send($email, $subject, $body)
    {
        return mail($email, $subject, $body);
    }
}