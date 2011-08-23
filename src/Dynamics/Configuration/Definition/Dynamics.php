<?php

/**
 * sfDynamicsConfigDefinition
 *
 * @package    sfDynamicsPlugin
 * @subpackage configuration
 * @version    SVN: $Id: $
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */
class Dynamics_Configuration_Definition_Dynamics extends Dynamics_Configuration_Definition
{
  protected
    $imports  = array(),
    $packages = array();

  /**
   * doPackage
   *
   * @param mixed $packageName
   * @param mixed $xml
   * @return void
   */
  public function doPackage($packageName, $xml)
  {
    $this->packages[$packageName] = new Dynamics_Configuration_Definition_Package($this->path, $xml);
  }

  /**
   * doImport
   *
   * @param mixed $resource
   * @return void
   */
  public function doImport($resource)
  {
    if (isset($this->imports[$resource]))
    {
      throw new sfConfigurationException($this->imports[$resource] ? 'Resource «'.$resource.'» is already imported.' : 'Resource «'.$resource.'» has a recursive import clause.');
    }

    $_files = $this->getConfigPaths($resource);

    if (count($_files))
    {
      $_file = $this->path.DIRECTORY_SEPARATOR.array_pop($_files);
      $_dir = realpath(dirname($_file));
      $_xml = simplexml_load_file($_file);

      $this->imports[$resource] = false;
      $_config = new self($_dir, $_xml);
      $this->merge($_config);
      $this->imports[$resource] = true;
    }
    else
    {
      throw new sfConfigurationException(sprintf('Could not find any suitable configuration file matching the resource referenced by <import> tag.%s The problematic resource is "%s".', "\n\n", $resource));
    }
  }

  /**
   * getImports
   *
   * @return void
   */
  public function getImports()
  {
    return $this->imports;
  }

  /**
   * getPackages
   *
   * @return void
   */
  public function getPackages()
  {
    return $this->packages;
  }

  /**
   * getPackage
   *
   * @param mixed $name
   * @return void
   */
  public function getPackage($name)
  {
    if (!isset($this->packages[$name]))
    {
      throw new Dynamics_Error_Configuration('Unknown required dynamics package «'.$name.'».'."\n\n".'If you just added or changed packages configuration, you should consider runing the cache:clear task on your project to regenerate configuration cache.');
    }

    return $this->packages[$name];
  }

  /**
   * setImports
   *
   * @param mixed $imports
   * @return void
   */
  public function setImports($imports)
  {
    $this->imports = $imports;
  }

  /**
   * setPackages
   *
   * @param mixed $packages
   * @return void
   */
  public function setPackages($packages)
  {
    $this->packages = $packages;
  }

  /**
   * merge
   *
   * @param mixed $config
   * @return void
   */
  public function merge($config)
  {
    $this->imports  = array_merge($this->imports, $config->getImports());

    foreach ($config->getPackages() as $packageName => $package)
    {
      if (isset($this->packages[$packageName]))
      {
        if (!$this->packages[$packageName]->isEqual($package))
        {
          throw new sfDynamicsConfigurationException(sprintf('Two different packages with name "%s" were included by configuration.', $packageName));
        }
      }
      else
      {
        $this->packages[$packageName] = $package;
      }
    }
  }

  /**
   * parseXml
   *
   * @param mixed $xml
   * @return void
   */
  public function parseXml($xml)
  {
    if (!($xml && $xml instanceof SimpleXMLElement))
    {
      throw new InvalidArgumentException('Invalid XML given');
    }

    if ($xml->getName()!='dynamics')
    {
      throw new sfDynamicsConfigurationException('Invalid XML file.'."\n\n".'Root node\'s tag name must be «dynamics».');
    }

    foreach ($xml->import as $import)
    {
      if (!$resource = (string)$import['resource'])
      {
        throw new sfDynamicsConfigurationException('Invalid «import» tag.'."\n\n".'A «resource» attribute is needed, containing the name of the resource to import.');
      }

      $this->doImport($resource);
    }

    foreach ($xml->package as $package)
    {
      $packageName = (string)$package['name'];

      if (!Dynamics_Configuration_Definition_Package::checkIsValidPackageName($packageName))
      {
        throw new sfConfigurationException(sprintf('Invalid package name «%s»', $packageName));
      }

      $this->doPackage($packageName, $package);
    }
  }

  static public function __set_state($state)
  {
    return self::build(new self(), array('imports', 'packages', 'paths'), $state);
  }
}

