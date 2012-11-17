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

class PhpArray extends Cache
{
    /**
     * @var Array
     */
    protected static $data;

    public function __construct()
    {
        if(empty(self::$data)) {
            self::$data = array();
        }
    }

    /**
     * 
     * @param String $name
     * @return Boolean
     */
    public function has($name)
    {
        return isset(self::$data[$this->normalizeName($name)]);
    }

    /**
     * 
     * @param String $name
     * @return Mixed
     */
    public function get($name)
    {  
        $name = $this->normalizeName($name);

        if(isset(self::$data[$name])) {
            return self::$data[$name];
        }

        return false;
    }

    /**
     * 
     * @param String $name
     * @param Mixed $data
     * @param Integer $ttl
     * @return Boolean
     */
    public function set($name, $data, $ttl = 0)
    {
        self::$data[$this->normalizeName($name)] = $data;
        return true;
    }

    /**
     * 
     * @param String $name
     * @return Boolean
     */
    public function remove($name)
    {
        $name = $this->normalizeName($name);
        
        if(isset(self::$data[$name])) {
            unset(self::$data[$name]);
        }

        return true;
    }

    /** 
     *
     * @return Boolean
     */
    public function flush()
    {
        self::$data = array();
        return true;
    }
}