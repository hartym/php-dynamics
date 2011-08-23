<?php

class Dynamics_Cache_NoCache implements Dynamics_Cache_Interface
{
  protected $options;

  public function __construct($options = array())
  {
    $this->options = $options;
  }

  public function generateKey(Dynamics_Configuration_Definition_AssetCollection $package, $type)
  {
    return '';
  }

  public function get($key, $default = null)
  {
    return $default;
  }

  public function has($key)
  {
    return false;
  }

  public function set($key, $data, $lifetime = null)
  {
    return true;
  }
}
