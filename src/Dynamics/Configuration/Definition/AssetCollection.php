<?php

/**
 * sfDynamicsAssetCollectionDefinition
 *
 * @package    sfDynamicsPlugin
 * @subpackage configuration
 * @version    SVN: $Id: $
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */
class Dynamics_Configuration_Definition_AssetCollection extends Dynamics_Configuration_Definition
{
  protected
    $stylesheets = array(),
    $javascripts = array();

  public function getCacheKey()
  {
    return implode(';', $this->getJavascripts()).';;'.implode(';', $this->getStylesheets());
  }

  public function hasStylesheets()
  {
    return !empty($this->stylesheets);
  }

  public function hasJavascripts()
  {
    return !empty($this->javascripts);
  }

  public function getModificationTimeFor($type)
  {
    $varname = $type.'s';
    $mtime = 0;

    foreach ($this->$varname as $asset)
    {
      $mtime = max($mtime, $asset->getModificationTime());
    }

    return $mtime;
  }

  public function parseXml($xml)
  {
    $xml = parent::parseXml($xml);

    if (isset($xml->javascript))
    {
      foreach ($xml->javascript as $index => $javascript)
      {
        $this->javascripts[] = new Dynamics_Configuration_Definition_Javascript($this->path, $javascript);
      }
    }

    if (isset($xml->stylesheet))
    {
      foreach ($xml->stylesheet as $index => $stylesheet)
      {
        $this->stylesheets[] = new Dynamics_Configuration_Definition_Stylesheet($this->path, $stylesheet);
      }
    }

    return $xml;
  }

  static public function __set_state($state)
  {
    return self::build(new self(), array('javascripts', 'stylesheets'), $state);
  }
}
