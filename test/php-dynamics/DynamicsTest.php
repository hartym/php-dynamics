<?php
// todo remove this
require_once dirname(__FILE__).'/../../src/php-dynamics/Dynamics/Autoloader.php';
Dynamics_Autoloader::register();

class DynamicsTest extends PHPUnit_Framework_TestCase
{
  public function testConstruct()
  {
    $config = new Dynamics_Configuration();
    $dynamics = new Dynamics($config);
  }
}

