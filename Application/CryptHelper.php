<?php
namespace Application;

/**
 * TDD
 *
 * @category  TDD
 * @copyright Copyright (c) 2015 by hr-interactive. All rights reserved.
 * @author    Ralf Schneider
 */
class CryptHelper
{
    protected static $salt = 'aölsdkfj';

    public static function getConfirmationCode()
    {
        return sha1(uniqid(self::$salt, true));
    }
}