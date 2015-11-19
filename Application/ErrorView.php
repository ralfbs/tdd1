<?php

/**
 * TDD
 *
 * @category  TDD
 * @copyright Copyright (c) 2015 by hr-interactive. All rights reserved.
 * @author    Ralf Schneider
 */
class ErrorView extends View
{
    protected $errorMessage;

    public function __construct($viewScript, $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        parent::__construct($viewScript);
    }
}