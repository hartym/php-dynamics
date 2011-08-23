<?php

class Dynamics_Controller
{
  protected $configuration = null;
  protected $content_type = '';

  public function __construct(Dynamics_Configuration $configuration)
  {
    $this->configuration = $configuration;
  }

  public function run($name, $parameters=array())
  {
    list($name, $extension) = $this->parseName($name);

    $package = $this->configuration->getPackage($name);
    $type = Dynamics::getTypeFromExtension($extension);
    $this->{'pre'.ucfirst($type)}($package);

    return $this->configuration->getRendererService()->getAsset($name, $package, $type, $extension);
  }

  public function getContentType()
  {
    return $this->content_type;
  }

  protected function parseName($name)
  {
    if (!Dynamics_Configuration_Definition_Package::checkIsValidPackageName($name))
    {
      throw new Dynamics_Error_InvalidPackageName(sprintf('"%s" is not a valid package name.', $name));
    }

    if (false === ($extensionPosition = strrpos($name, '.')))
    {
      throw new Dynamics_Error_InvalidAssetType('No extension given.');
    }

    $extension = substr($name, $extensionPosition+1);
    $name = substr($name, 0, $extensionPosition);

    return array($name, $extension);
  }

  protected function preJavascript($package)
  {
    if (!(count($package->getJavascripts()) && count($package->getPaths($this->configuration->getGlobalAssetPaths()))))
    {
      throw new Dynamics_Error('This package has no javascript assets, or no search path is set on package.');
    }

    $this->content_type = 'text/javascript';
  }

  protected function preStylesheet($package)
  {
    if (!(count($package->getStylesheets()) && count($package->getPaths($this->configuration->getGlobalAssetPaths()))))
    {
      throw new Dynamics_Error('This package has no stylesheet assets, or no search path is set on package.');
    }

    $this->content_type = 'text/css';
  }
}
