<?php

namespace EasyMeituan\MeituanDispath;

use Hanson\Foundation\Foundation;

class Dispatch extends Foundation
{
    private $order;

    public function __construct($config)
    {
        parent::__construct($config);

        $this->order = new Order();
    }

    public function __call($name, $arguments)
    {
        return $this->order->{$name}(...$arguments);
    }
}