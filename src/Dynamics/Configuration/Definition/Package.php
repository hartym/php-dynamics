<?php

class Dynamics_Configuration_Definition_Package extends Dynamics_Configuration_Definition_AssetCollection
{
  protected
    $description  = '',
    $prependPaths = array(),
    $appendPaths  = array(),
    $requires     = array(),
    $conflicts    = array(),
    $i18n         = array(),
    $themes       = array();

  public function isEqual(sfDynamicsPackageDefinition $package)
  {
    return md5(serialize($this)) == md5(serialize($package));
  }

  public function setPrependPaths($paths)
  {
    $this->prependPaths = $paths;
  }

  public function setAppendPaths($paths)
  {
    $this->appendPaths = $paths;
  }

  public function getPaths($hackish=array())
  {
    return array_merge($this->prependPaths, array($this->path), $hackish, $this->appendPaths);
  }

  public function getDependencies()
  {
    return $this->requires;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function setRequires($requires)
  {
    $this->requires = $requires;
  }

  public function setConflicts($conflicts)
  {
    $this->conflicts = $conflicts;
  }

  public function setI18n($i18n)
  {
    $this->i18n = $i18n;
  }

  public function setThemes($themes)
  {
    $this->themes = $themes;
  }

  public function parseXml($xml)
  {
    $xml = parent::parseXml($xml);

    if (isset($xml->path))
    {
      foreach ($xml->path as $path)
      {
        switch (isset($path['priority']) ? $path['priority'] : 'high')
        {
          case 'high':
            $this->appendPaths[] = $this->parsePath((string)$path);
            break;
          case 'low':
            $this->prependPaths[] = $this->parsePath((string)$path);
            break;
          default:
            throw new sfConfigurationException('Path «priority» attribute can only be «high» or «low».');
        }
      }
    }

    if (isset($xml->require))
    {
      foreach ($xml->require as $require)
      {
        $this->requires[] = (string)$require;
      }
    }

    if (isset($xml->conflict))
    {
      foreach ($xml->conflict as $conflict)
      {
        $this->conflicts[] = (string)$conflict;
      }
    }

    if (isset($xml->i18n))
    {
      foreach ($xml->i18n as $i18n)
      {
        if (!strlen($language = (string)$i18n['language']))
        {
          throw new sfConfigurationException('Each I18n tag should have a language attribute.');
        }

        $this->i18n[$language] = new sfDynamicsAssetCollectionDefinition($i18n);
      }
    }

    if (isset($xml->theme))
    {
      $hasDefault = false;

      foreach ($xml->theme as $theme)
      {
        if (!strlen($themeName = (string)$theme['name']))
        {
          throw new sfConfigurationException('Each theme tag should have a name attribute.');
        }

        $this->themes[$themeName] = new sfDynamicsAssetCollectionDefinition($theme);
      }
    }

    return $xml;
  }

  /**
   * Is the given name a semantically correct package identifier?
   *
   * @param  string $name
   * @return boolean
   */
  static public function checkIsValidPackageName($name)
  {
    return preg_match('/^[a-z0-9._-]+$/i', $name);
  }

  static public function __set_state($state)
  {
    return self::build(new self(), array('javascripts', 'stylesheets', 'description', 'requires', 'conflicts', 'i18n', 'themes', 'prependPaths', 'appendPaths', 'paths'), $state);
  }
}

