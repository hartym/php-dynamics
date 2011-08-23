<?php

/*
 * This file is part of PHP-Dynamics.
 *
 * (c) 2008-2010 Romain Dorgueil
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Autoloads PHP-Dynamics classes.
 *
 * @package    php-dynamics
 * @author     Romain Dorgueil <romain.dorgueil@dakrazy.net>
 * @version    SVN: $Id$
 */
class Dynamics_Autoloader
{
  /**
   * Registers Dynamics_Autoloader as an SPL autoloader.
   */
  static public function register()
  {
    ini_set('unserialize_callback_func', 'spl_autoload_call');
    spl_autoload_register(array(new self, 'autoload'));
  }

  /**
   * Handles autoloading of classes.
   *
   * @param  string  $class  A class name.
   *
   * @return boolean Returns true if the class has been loaded
   */
  static public function autoload($class)
  {
    if (0 !== strpos($class, 'Dynamics'))
    {
      return false;
    }

    require dirname(__FILE__).'/../'.str_replace('_', '/', $class).'.php';

    return true;
  }
}
