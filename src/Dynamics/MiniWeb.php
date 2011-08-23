<?php

class Dynamics_MiniWeb
{
  // @TODO move $paths to dynamics ?
  static public function run($filenames, $paths=array())
  {
    $name = self::getName();

    // create objects
    $configuration = new Dynamics_Configuration(array(
        Dynamics_Configuration::GLOBAL_ASSET_PATHS => $paths
      ));
    $configuration->loadFromFiles($filenames);

    $dynamics = new Dynamics($configuration);
    $controller = new Dynamics_Controller($configuration);

    // run it
    $result = $controller->run($name);

    // display
    header(sprintf('Content-type: %s', $controller->getContentType()));
    die($result);
  }

  static public function getName()
  {
    if (isset($_GET['name']) && strlen($_GET['name']))
    {
      $name = $_GET['name'];
    }
    elseif (isset($_SERVER['PATH_INFO']) && strlen($_SERVER['PATH_INFO'])>1)
    {
      $name = substr($_SERVER['PATH_INFO'], 1);
    }
    else
    {
      throw new Dynamics_Error_InvalidPackageName('No package name.');
    }

    if (false === strpos($name, '.'))
    {
      throw new Dynamics_Error_InvalidPackageName('Package name must have an extension.');
    }

    return $name;
  }
}

