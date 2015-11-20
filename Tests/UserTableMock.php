<?php

/**
 * Created by PhpStorm.
 * User: user1
 * Date: 19.11.2015
 * Time: 16:36
 */
class UserTableMock extends \Application\UserTable
{
    public $getUserByEmail = false;

    public $updateCodeByEmail;


    public function getUserByEmail($email)
    {
        return $this->getUserByEmail;
    }

    public function updateCodeByEmail($email)
    {
        return $this->updateCodeByEmail;
    }
}