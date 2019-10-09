<?php

namespace EasyMeituan\MeituanDispath;

use EasyMeituan\Tests\TestServiceProvider;
use Hanson\Foundation\Foundation;


/**
 * Class Dispatch
 * @package EasyMeituan\MeituanDispath
 *
 * @property \EasyMeituan\Tests\Test         $test
 *
 * @method array createByShop($params)
 * @method array queryStatus($params)
 * @method array createByCoordinates($params)
 * @method array delete($params)
 * @method array evaluate($params)
 * @method array check($params)
 * @method array location($params)
 */
class Dispatch extends Foundation
{
    private $order;

    protected $providers = [
        TestServiceProvider::class
    ];

    public function __construct($config)
    {
        parent::__construct($config);

        $this->order = new Order($config['app_key'], $config['secret']);
    }

    public function __call($name, $arguments)
    {
        return $this->order->{$name}(...$arguments);
    }
}