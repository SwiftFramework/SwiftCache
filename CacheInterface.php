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

interface CacheInterface
{
    /**
     * 
     * @param String $name
     * @return Boolean
     */
    public function has($name);
    
    /**
     * 
     * @param String $name
     * @return Mixed
     */
    public function get($name);

    /**
     * 
     * @param String $name
     * @param Mixed $data
     * @param Integer $ttl
     * @return Boolean
     */
    public function set($name, $data, $ttl = 0);

    /**
     * 
     * @param String $name
     * @return Boolean
     */
    public function remove($name);

    /** 
     *
     * @return Boolean
     */
    public function flush();
}