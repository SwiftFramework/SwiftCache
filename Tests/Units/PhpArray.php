<?php

namespace Swift\Cache\Tests\Units;

require_once __DIR__ . '/../../vendor/autoload.php';

use mageekguy\atoum;
use mageekguy\atoum\factory;
use Swift;

class PhpArray extends atoum\test 
{
    public function __construct(factory $factory = null)
    {
        $this->setTestNamespace('Tests\\Units');
        parent::__construct($factory);
    }

    public function testClass()
    {
        $this->assert->class("\Swift\Cache\PhpArray")
            ->hasInterface('\Swift\Cache\CacheInterface');

        $cache = new Swift\Cache\PhpArray();

        $this->assert->object($cache)
            ->isInstanceOf('\Swift\Cache\PhpArray');

        $cache->set('foot', 'bar');

        $this->assert->string($cache->get('foot'))
            ->isEqualTo('bar');

        $this->assert->boolean($cache->get('foot4'))
            ->isFalse();

        $this->assert->boolean($cache->has('foot'))
            ->isTrue();

        $this->assert->boolean($cache->has('foot4'))
            ->isFalse();

        $cache->remove('foot');

        $this->assert->boolean($cache->get('foot'))
            ->isFalse();

        $this->assert->boolean(isset($cache['foot4']))
            ->isFalse();

        $cache->set('foot', 'bar');
        $cache->set('foot1', 'bar1');

        $cache->flush();

        $this->assert->boolean($cache->has('foot'))
            ->isFalse();

        $this->assert->boolean($cache->has('foot1'))
            ->isFalse();
    }

    public function testArrayAccess()
    {
        $cache = new Swift\Cache\PhpArray();

        $cache['foot4'] = 'bar4';

        $this->assert->boolean(isset($cache['foot4']))
            ->isTrue();

        $this->assert->string($cache['foot4'])
            ->isEqualTo('bar4');

        unset($cache['foot4']);

        $this->assert->boolean(isset($cache['foot4']))
            ->isFalse();
    }
}