<?php

/**
 * sfDynamicsJavascriptDefinition
 *
 * @package    sfDynamicsPlugin
 * @subpackage configuration
 * @version    SVN: $Id: $
 * @author     Geoffrey Bachelet <geoffrey.bachelet@gmail.com>
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */
class Dynamics_Configuration_Definition_Javascript extends Dynamics_Configuration_Definition_Asset
{
  public function getExtension()
  {
    return 'js';
  }

  /**
   * @todo remove in php 5.3
   */
  static public function __set_state($state)
  {
    return self::build(new self(), array('resource', 'options', 'path'), $state);
  }
}
