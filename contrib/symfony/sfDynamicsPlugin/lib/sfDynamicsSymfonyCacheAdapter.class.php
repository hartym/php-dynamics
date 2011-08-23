<?php

/**
 * Decorator adapting any sfCache subclass to Dynamics_Cache_Interface. TODO update this.
 *
 * Etonnant, non ?
 */

class sfDynamicsSymfonyCacheAdapter implements Dynamics_Cache_Interface
{
  protected $implementation = null;

  public function __construct($options = array())
  {
    foreach(array('implementation', 'cache_dir') as $key)
    {
      if (!isset($options[$key]))
      {
        throw new Dynamics_Error_MissingRequiredOption(sprintf('"%s" option is mandatory.', $key));
      }
    }

    $cls = $options['implementation'];
    $this->implementation = new $cls($options);
  }

  public function generateKey(Dynamics_Configuration_Definition_AssetCollection $package, $type)
  {
    return 'TODO';
  }

  /**
   * Gets the cache content for a given key.
   *
   * @param string $key     The cache key
   * @param mixed  $default The default value is the key does not exist or not valid anymore
   *
   * @return mixed The data of the cache
   */
  public function get($key, $default = null)
  {
    // throw new Exception('TODO: get() not yet implemented');
  }

  /**
   * Returns true if there is a cache for the given key.
   *
   * @param string $key The cache key
   *
   * @return Boolean true if the cache exists, false otherwise
   */
  public function has($key)
  {
    return false;
  }

  /**
   * Saves some data in the cache.
   *
   * @param string $key      The cache key
   * @param mixed  $data     The data to put in cache
   * @param int    $lifetime The lifetime
   *
   * @return Boolean true if no problem
   */
  public function set($key, $data, $lifetime = null)
  {
    return true;
  }
  
  
  /**
   * Clear dynamics folder cache.
   */
  static function listenToClearCache(sfEvent $event)
  {
    $dymanics_cache_path = sfConfig::get('sf_web_dir').'/dynamics';
    
    if (file_exists($dymanics_cache_path))
    {
      $filesystem = new sfFilesystem(new sfEventDispatcher(), new sfFormatter());
      $filesystem->remove(sfFinder::type('file')->discard('.sf')->in($dymanics_cache_path));
    }
  }
}
