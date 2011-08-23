<?php

/**
 * sfDynamicsAssetCollectionDefinition
 *
 * @package    sfDynamicsPlugin
 * @subpackage configuration
 * @version    SVN: $Id: $
 * @author     Geoffrey Bachelet <geoffrey.bachelet@gmail.com>
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */
abstract class Dynamics_Configuration_Definition_Asset extends Dynamics_Configuration_Definition
{
  protected
    $resource,
    $options = array();

  abstract public function getExtension();

  public function getFilteredContent(Dynamics_Configuration_Definition_AssetCollection $package)
  {
    return file_get_contents($this->path.'/'.$this->resource);
  }

  public function parseXml($xml)
  {
    $this->resource = (string) $xml;

    if (!$this->resource)
    {
      throw new sfDynamicsConfigurationException();
    }

    $this->path = realpath($this->path.DIRECTORY_SEPARATOR.dirname($this->resource));
    if (!$this->path)
    {
      throw new RuntimeException($this->resource.' does not exist (containing folder is not there).');
    }

    $this->resource = basename($this->resource);

    if (isset($xml['image_path_prefix']))
    {
      $this->options['image_path_prefix'] = (string) $xml['image_path_prefix'];
    }

    $this->options['type'] = self::getElementName($xml);
  }

  public function getModificationTime()
  {
    return filemtime($this->getPath());
  }

  public function __toString()
  {
    return $this->resource;
  }

  /**
   * @todo in php 5.3 use static keyword instead of self
   */
  static public function __set_state($state)
  {
    return self::build(new self(), array('resource', 'options'), $state);
  }
}
