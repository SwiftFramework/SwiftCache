<?php
/**
 * @package     Swift\Cache
 * @author      Axel Etcheverry <axel@etcheverry.biz>
 * @copyright   Copyright (c) 2012 Axel Etcheverry (http://www.axel-etcheverry.com)
 * @license     MIT
 */

/**
 * @namespace
 */
namespace Swift\Cache;

use ArrayAccess;

abstract class Cache implements CacheInterface, ArrayAccess
{
    /**
     * @var Integer
     */
    protected $ttl = 3600;

    /**
     *
     * @param String $name;
     * @return String
     */
    public function normalizeName($name)
    {
        return strtolower(str_replace(array(
            ' ',
            '-',
            '.',
            ','
        ), 
        array(
            '_',
            '_',
            '_',
            '_'
        ), $name));
    }

    /**
     * Determine if a cached value exists.
     *
     * @param String $name
     * @return Boolean
     */
    public function offsetExists($name)
    {
        return $this->has($name);
    }

    /**
     * Retrieve an item from the cache by name.
     *
     * @param String $name
     * @return Mixed
     */
    public function offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * Store an item in the cache for the default ttl.
     *
     * @param String $name
     * @param Mixed $value
     * @return Void
     */
    public function offsetSet($name, $value)
    {
        $this->set($name, $value, $this->ttl);
    }

    /**
     * Remove an item from the cache.
     *
     * @param String $name
     * @return Void
     */
    public function offsetUnset($name)
    {
        $this->remove($name);
    }
}