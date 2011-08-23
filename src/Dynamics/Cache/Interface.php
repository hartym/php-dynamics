<?php

interface Dynamics_Cache_Interface
{
  public function __construct($options = array());

  public function generateKey(Dynamics_Configuration_Definition_AssetCollection $package, $type);

  /**
   * Gets the cache content for a given key.
   *
   * @param string $key     The cache key
   * @param mixed  $default The default value is the key does not exist or not valid anymore
   *
   * @return mixed The data of the cache
   */
  public function get($key, $default = null);

  /**
   * Returns true if there is a cache for the given key.
   *
   * @param string $key The cache key
   *
   * @return Boolean true if the cache exists, false otherwise
   */
  public function has($key);

  /**
   * Saves some data in the cache.
   *
   * @param string $key      The cache key
   * @param mixed  $data     The data to put in cache
   * @param int    $lifetime The lifetime
   *
   * @return Boolean true if no problem
   */
  public function set($key, $data, $lifetime = null);
}
