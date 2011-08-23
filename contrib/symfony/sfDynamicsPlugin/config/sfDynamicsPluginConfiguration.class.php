<?php

/**
 * sfDynamicsPlugin configuration.
 *
 * @package     sfDynamicsPlugin
 * @subpackage  config
 * @author      Romain Dorgueil <romain@dorgueil.net>
 * @license     WTFPL
 */
class sfDynamicsPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    require dirname(__FILE__).'/config.php';
    require_once dirname(__FILE__).'/../lib/debug/sfWebDebugPanelDynamics.class.php';

    $this->dispatcher->connect('debug.web.load_panels', array('sfWebDebugPanelDynamics', 'listenToLoadPanelEvent'));
    $this->dispatcher->connect('task.cache.clear', array('sfDynamicsSymfonyCacheAdapter', 'listenToClearCache'));
  }
}
