<?php
/**
 * @package     Swift
 * @author      Axel Etcheverry <axel@etcheverry.biz>
 * @copyright   Copyright (c) 2012 Axel Etcheverry (http://www.axel-etcheverry.com)
 * @license     MIT
 */

/**
 * @namespace
 */
namespace Swift\Cache;

class ArrayStore extends Store
{
    /**
     * The array of stored values.
     *
     * @var Array
     */
    protected static $storage;


    public function __construct()
    {
        if (empty(self::$storage)) {
            self::$storage = array();
        }

        parent::__construct();
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  String  $key
     * @return Mixed
     */
    protected function retrieveItem($key)
    {
        if (array_key_exists($key, self::$storage)) {
            return self::$storage[$key];
        }
    }

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  String  $key
     * @param  Mixed   $value
     * @param  Integer $minutes
     * @return Void
     */
    protected function storeItem($key, $value, $minutes = 0)
    {
        self::$storage[$key] = $value;
    }

    /**
     * Remove an item from the cache.
     *
     * @param  String  $key
     * @return Void
     */
    protected function removeItem($key)
    {
        unset(self::$storage[$key]);
    }

    /**
     * Remove all items from the cache.
     *
     * @return Void
     */
    protected function flushItems()
    {
        self::$storage = array();
    }
}