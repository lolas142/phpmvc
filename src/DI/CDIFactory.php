<?php

namespace Anax\DI;

/**
 * Extended factory for Anax documentation.
 *
 */
class CDIFactory extends CDIFactoryDefault
{
    public function __construct()
    {
        parent::__construct();
 
        $this->set('form', '\Mos\HTMLForm\CForm');
    }
}
