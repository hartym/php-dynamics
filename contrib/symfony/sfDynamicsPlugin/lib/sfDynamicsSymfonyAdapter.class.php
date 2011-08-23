<?php

class sfDynamicsSymfonyAdapter extends Dynamics
{
  protected $dispatcher;
  protected $configuration;

  public function __construct(sfEventDispatcher $dispatcher)
  {
    $this->dispatcher = $dispatcher;

    // TODO $this->dispatcher->connect('task.cache.clear', array('sfDynamicsCache', 'clearSuperCache'));

    $this->configuration = new sfDynamicsConfiguration(array(
      Dynamics_Configuration::ROUTING_SERVICE_CLASS => 'sfDynamicsRouting',
      Dynamics_Configuration::WEB_DIR => sfConfig::get('sf_web_dir'),
      Dynamics_Configuration::CACHE_SERVICE_CLASS => 'sfDynamicsSymfonyCacheAdapter',
      Dynamics_Configuration::CACHE_SERVICE_OPTIONS => array(
        array(
          'implementation' => 'Dynamics_Cache_NoCache' /* TODO adapt symfony cache */,
          'cache_dir' => '/tmp' /* TODO use sf cache dir */,
        )
      ),
    ));

    parent::__construct($this->configuration);
  }

  public function loadConfiguration()
  {
    $configurationFiles = array(
            sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'dynamics.xml',
            sfConfig::get('sf_app_config_dir').DIRECTORY_SEPARATOR.'dynamics.xml'
          );

    foreach (sfContext::getInstance()->getConfiguration()->getPluginPaths() as $pluginPath)
    {
      $configurationFiles[] = $pluginPath.'/config/dynamics.xml';
    }

    $this->configuration->loadFromFiles(array_filter($configurationFiles, 'file_exists'));
  }

  protected function setup()
  {
    $this->dispatcher->connect('response.filter_content', array($this, 'filterResponseContent'));
    $this->dispatcher->connect('routing.load_configuration', array('sfDynamicsRouting', 'configure'));
    $this->dispatcher->connect('routing.load_configuration', array($this, 'loadConfiguration'));
  }

  /**
   * Uses symfony events to filter response content.
   *
   * @param  sfEvent $event
   * @param  string  $content
   * @return string
   */
  public function filterResponseContent(sfEvent $event, $content)
  {
    // TODO $prepend  = sfDynamicsConfig::getAssetsPositionInHead() == 'prepend';
    $prepend = true;

    $response = $event->getSubject();

    if ($prepend)
    {
      $pos = strpos($content, '<head>');

      if ($pos !== false)
      {
        // skip the <head> tag
        $pos += 6;
      }
    }
    else
    {
      $pos = strpos($content, '</head>');
    }

    if (false !== $pos)
    {
      $html = $this->render();

      if ($html)
      {
        $content = substr($content, 0, $pos)."\n".$html.substr($content, $pos);
      }
    }

    return $content;
  }
}
