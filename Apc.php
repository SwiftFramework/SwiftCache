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

use RuntimeException;

class Apc extends Cache
{
    /**
     * @var String
     */
    protected $prefix = "swift_cache_storage_";

    /**
     * @throws \RuntimeException
     */
    public function __construct($prefix = null)
    {
        if(version_compare('3.1.6', phpversion('apc')) > 0) {
            throw new RuntimeException("Missing ext/apc >= 3.1.6");
        }

        $enabled = ini_get('apc.enabled');
        if(PHP_SAPI == 'cli') {
            $enabled = $enabled && (bool) ini_get('apc.enable_cli');
        }

        if (!$enabled) {
            throw new RuntimeException(
                "ext/apc is disabled - see 'apc.enabled' and 'apc.enable_cli'"
            );
        }

        if (!empty($prefix)) {
            $this->prefix = $this->normalizeName($prefix);
        }
    }

    /**
     * Checks if APC key exists
     * 
     * @param String $name
     * @return Boolean
     */
    public function has($name)
    {
        return apc_exists(
            $this->prefix . $this->normalizeName($name)
        );
    }

    /**
     * Fetch a stored variable from the cache
     * 
     * @param String $name
     * @return Mixed
     */
    public function get($name)
    {
        return apc_fetch(
            $this->prefix . $this->normalizeName($name)
        );
    }

    /**
     * Cache a variable in the data store
     * 
     * @param String $name
     * @param Mixed $data
     * @param Integer $ttl
     * @return Boolean
     */
    public function set($name, $data, $ttl = 0)
    {
        return apc_store(
            $this->prefix . $this->normalizeName($name), 
            $data, 
            $ttl
        );
    }

    /**
     * Removes a stored variable from the cache
     * 
     * @param String $name
     * @return Boolean
     */
    public function remove($name)
    {
        return apc_delete(
            $this->prefix . $this->normalizeName($name)
        );
    }

    /** 
     *
     * @return Boolean
     */
    public function flush()
    {
        return apc_clear_cache('user');
    }
}