<?php

class Dynamics_Loader
{
  protected $configuration;
  protected $isXmlHttpRequest;
  protected $assets;

  /** @var array */
  protected $packages = array();

  public function __construct(Dynamics_Configuration $configuration)
  {
    $this->configuration = $configuration;
  }

  /**
   * Loads a package, and its dependencies.
   *
   * @param string -- Package name, as defined in loaded xml configuration
   *                  files "name" attribute of "package" tags.
   */
  public function load($name)
  {
    if (!$this->loaded($name))
    {
      $this->packages[$name] = false;

      try
      {
        $package = $this->configuration->getPackage($name);

        foreach($package->getDependencies() as $dependency)
        {
          $this->load($dependency);
        }

        // This is needed to preserve assets order.
        unset($this->packages[$name]);
        $this->packages[$name] = $package;
      }
      catch (Exception $e)
      {
        // could not load package
        unset($this->packages[$name]);
        throw $e;
      }
    }
  }

  /**
   * Returns whether or not a package is loaded.
   *
   * Of course, a package that is being loaded (and which has is value SET but
   * === false) will be said not loaded yet, as it's not finished.
   *
   * @param  mixed   $package
   * @return boolean
   */
  public function loaded($name)
  {
    return isset($this->packages[$name]) && $this->packages[$name];
  }

  public function getPackages()
  {
    return $this->packages;
  }
}

