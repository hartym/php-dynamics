<?php

/**
 * Dynamics_AssetFilter_Stylesheet_Simple
 *
 * Uses a simple regex to filter stylesheet content.
 *
 * @package    Dynamics
 * @subpackage AssetFilter
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */

class Dynamics_AssetFilter_Stylesheet_Simple extends Dynamics_AssetFilter
{
  protected function doFilter($code)
  {
    return preg_replace('/\s\s+/m', ' ', str_replace(array("\n", "\t"), ' ', $code));
  }
}
