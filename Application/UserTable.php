<?php
/**
 * Created by PhpStorm.
 * User: user1
 * Date: 19.11.2015
 * Time: 16:23
 */

namespace Application;


class UserTable
{

    public function getUserByEmail($email)
    {
        $db = new \PDO(Config::get('dsn'));
        $stmt = $db->prepare('SELECT * FROM Users WHERE email=:email');
        $stmt->execute(array(':email' => $email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }


    public function updateCodeByEmail($code, $email)
    {
        $db = new \PDO(Config::get('dsn'));
        $stmt = $db->prepare('UPDATE Users SET code=:code WHERE email=:email');
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->bindValue(':email',$email, PDO::PARAM_STR);
        $stmt->execute();
    }

}