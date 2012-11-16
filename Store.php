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

use ArrayAccess;
use Closure;

abstract class Store implements ArrayAccess
{
    /**
     * The items retrieved from the cache.
     *
     * @var Array
     */
    protected static $items;

    /**
     * The default number of minutes to store items.
     *
     * @var Integer
     */
    protected $default = 60;

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  String  $key
     * @return Mixed
     */
    abstract protected function retrieveItem($key);

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  String  $key
     * @param  Mixed   $value
     * @param  Integer $minutes
     * @return Void
     */
    abstract protected function storeItem($key, $value, $minutes);

    /**
     * Remove an item from the cache.
     *
     * @param  String  $key
     * @return Void
     */
    abstract protected function removeItem($key);

    /**
     * Remove all items from the cache.
     *
     * @return Void
     */
    abstract protected function flushItems();

    public function __construct()
    {
        if (empty(self::$items)) {
            self::$items = array();
        }
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param  String  $key
     * @return Boolean
     */
    public function has($key)
    {
        return !is_null($this->get($key));
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  String  $key
     * @param  Mixed   $default
     * @return Mixed
     */
    public function get($key, $default = null)
    {
        // The store keeps all already accessed items in memory so they don't need
        // to be retrieved again on subsequent calls into the cache. This is to
        // help increase the speed of an application and not waste any trips.
        if (array_key_exists($key, self::$items)) {
            return self::$items[$key];
        }

        $value = $this->retrieveItem($key);

        // If the items are not present in the caches, we will return this default
        // value that was supplied. If it is a Closure we'll execute it so the
        // the execution of an intensive operation will get lazily executed.
        if (is_null($value)) {
            return $default;
        }

        return self::$items[$key] = $value;
    }

    /**
     * Store an item in the cache.
     *
     * @param  String  $key
     * @param  Mixed   $value
     * @param  Integer $minutes
     * @return Void
     */
    public function set($key, $value, $minutes = 0)
    {
        self::$items[$key] = $value;

        return $this->storeItem($key, $value, $minutes);
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  String   $key
     * @param  Integer  $minutes
     * @param  Closure  $callback
     * @return Mixed
     */
    public function remember($key, $minutes, Closure $callback)
    {
        // If the item exists in the cache, we will just return it immediately,
        // otherwise we will execute the given Closure and cache the result
        // of that execution for the given number of minutes in storage.
        if ($this->has($key)) {
            return $this->get($key);
        }

        $this->set($key, $value = $callback(), $minutes);

        return $value;
    }

    /**
     * Get an item from the cache, or store the default value forever.
     *
     * @param  String   $key
     * @param  Closure  $callback
     * @return 
     */
    public function rememberForever($key, Closure $callback)
    {
        // If the item exists in the cache, we will just return it immediately,
        // otherwise we will execute the given Closure and cache the result
        // of that execution for the given number of minutes. It's easy.
        if ($this->has($key)) {
            return $this->get($key);
        }

        $this->forever($key, $value = $callback());

        return $value;  
    }

    /**
     * Remove an item from the cache.
     *
     * @param  String  $key
     * @return Void
     */
    public function forget($key)
    {
        unset(self::$items[$key]);

        return $this->removeItem($key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return Void
     */
    public function flush()
    {
        self::$items = array();

        return $this->flushItems();
    }

    /**
     * Get the default cache time.
     *
     * @return Integer
     */
    public function getDefaultCacheTime()
    {
        return $this->default;
    }

    /**
     * Set the default cache time in minutes.
     *
     * @param  Integer $minutes
     * @return Void
     */
    public function setDefaultCacheTime($minutes)
    {
        $this->default = $minutes;

        return $this;
    }

    /**
     * Determine if an item is in memory.
     *
     * @param  String  $key
     * @return Boolean
     */
    public function existsInMemory($key)
    {
        return array_key_exists($key, self::$items);
    }

    /**
     * Get all of the values in memory.
     *
     * @return Array
     */
    public function getMemory()
    {
        return self::$items;
    }

    /**
     * Get the value of an item in memory.
     *
     * @param  String  $key
     * @return Mixed
     */
    public function getFromMemory($key)
    {
        return self::$items[$key];
    }

    /**
     * Set the value of an item in memory.
     *
     * @param  String  $key
     * @param  Mixed   $value
     * @return Void
     */
    public function setInMemory($key, $value)
    {
        self::$items[$key] = $value;
    }

    /**
     * Determine if a cached value exists.
     *
     * @param  String  $key
     * @return Boolean
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  String  $key
     * @return Mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Store an item in the cache for the default time.
     *
     * @param  String  $key
     * @param  Mixed   $value
     * @return Void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value, $this->default);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  String  $key
     * @return Void
     */
    public function offsetUnset($key)
    {
        return $this->forget($key);
    }
}