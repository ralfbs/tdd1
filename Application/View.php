<?php
namespace Application;

/**
 * TDD
 *
 * @category  TDD
 * @copyright Copyright (c) 2015 by hr-interactive. All rights reserved.
 * @author    Ralf Schneider
 */
class View
{
    protected $viewScript;

    public function __construct($viewScript)
    {
        $this->viewScript = $viewScript;
    }
}