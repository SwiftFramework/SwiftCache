<?php

namespace Swift\Cache\Tests\Units;

require_once __DIR__ . '/../../vendor/autoload.php';

use mageekguy\atoum;
use mageekguy\atoum\factory;
use Swift;

class ArrayStore extends atoum\test 
{
    public function __construct(factory $factory = null)
    {
        $this->setTestNamespace('Tests\\Units');
        parent::__construct($factory);
    }

    public function testClass()
    {
        $cache = new Swift\Cache\ArrayStore();

        $this->assert->object($cache)
            ->isInstanceOf('\Swift\Cache\ArrayStore');

        $this->assert->boolean($cache->has('foot'))
            ->isFalse();

        $cache->set('foot', 'bar');

        $this->assert->boolean($cache->has('foot'))
            ->isTrue();

        $this->assert->string($cache->get('foot'))
            ->isEqualTo('bar');

        $cache = new Swift\Cache\ArrayStore();

        $this->assert->boolean($cache->has('foot'))
            ->isTrue();

        $cache->flush();

        $this->assert->boolean($cache->has('foot'))
            ->isFalse();
    }
}