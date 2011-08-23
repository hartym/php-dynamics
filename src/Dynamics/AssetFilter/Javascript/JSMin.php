<?php

/**
 * sfDynamicsJSMinJavascriptFilter
 *
 * Minifies javascript with vendor library JSMin.
 *
 * @package    Dynamics
 * @subpackage AssetFilter
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */

class Dynamics_AssetFilter_Javascript_JSMin extends Dynamics_AssetFilter
{
  protected function doFilter($code)
  {
    return JSMin::minify($code);
  }
}

