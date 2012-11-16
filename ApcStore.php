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

use RuntimeException;

class ApcStore extends Store
{
    /**
     * @var String
     */
    protected $prefix = "swift_cache_storage_";

    /**
     *
     * @param String|Null $prefix
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
            $this->prefix = $prefix;
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
        $value = apc_fetch($this->prefix . $key);

        if ($value !== false) {
            return $value;
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
        apc_store($this->prefix . $key, $value, $minutes * 60);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  String  $key
     * @return Void
     */
    protected function removeItem($key)
    {
        apc_delete($this->prefix . $key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return Void
     */
    protected function flushItems()
    {
        apc_flush();
    }
}