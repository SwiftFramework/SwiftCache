Cache Component
=================

The example below demonstrates how you can set up a fully working cache
system:

    use Swift\Cache\ApcStore;

    $cache = new ApcStore();
    $cache->set('foot', 'bar');

    echo $cache->get('foot');

Resources
---------

You can run the unit tests with the following command:

    $ cd path/to/Swift/Cache/
    $ curl -s https://getcomposer.org/installer | php
    $ php composer.phar install --dev
    $ ./vendor/mageekguy/atoum/bin/atoum --glob Tests/Units/