<?php

namespace Application;

/**
 * TDD
 *
 * @category  TDD
 * @copyright Copyright (c) 2015 by hr-interactive. All rights reserved.
 * @author    Ralf Schneider
 */
class Config
{

    public static $values = array();

    public static function init(array $values)
    {
        self::$values = $values;
    }

    public static function get($key)
    {
        if (!isset(self::$values[$key])) {
            throw new \Exception ('Schlüssel nicht gefunden');
        }
        return self::$values[$key];
    }
}