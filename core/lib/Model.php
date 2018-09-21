<?php

namespace core\lib;

use Medoo\Medoo;

class Model extends Medoo
{
    public function __construct()
    {
        $option = Config::all('database');
        parent::__construct($option);
    }
}