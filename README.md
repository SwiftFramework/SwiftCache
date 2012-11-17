Cache Component
=================

[![Build Status](https://secure.travis-ci.org/SwiftFramework/SwiftCache.png)](http://travis-ci.org/SwiftFramework/SwiftCache)

The example below demonstrates how you can set up a fully working cache
system:

    use Swift\Cache\Apc;

    $cache = new Apc();
    $cache->set('foot', 'bar');

    echo $cache->get('foot');

    $cache->remove('foot');

    $cache['test'] = 'bar';

Resources
---------

You can run the unit tests with the following command:

    $ cd path/to/Swift/Cache/
    $ curl -s https://getcomposer.org/installer | php
    $ php composer.phar install --dev
    $ ./vendor/mageekguy/atoum/bin/atoum --glob Tests/Units/