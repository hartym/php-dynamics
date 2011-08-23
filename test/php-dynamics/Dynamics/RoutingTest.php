<?php
require_once dirname(__FILE__).'/../../../src/php-dynamics/Dynamics/Routing.php';

class RoutingTest extends PHPUnit_Framework_TestCase
{
  public function testGetUrlFor1()
  {
    $routing = new Dynamics_Routing();
    $this->assertEquals('/dynamics.php/foo.js', $routing->getUrlFor('foo', 'js'));
    $this->assertEquals('/dynamics.php/bar.css', $routing->getUrlFor('bar', 'css'));
  }

  public function testGetUrlFor2()
  {
    $routing = new Dynamics_Routing(array('css'=>'/css/'));
    $this->assertEquals('/dynamics.php/foo.js', $routing->getUrlFor('foo', 'js'));
    $this->assertEquals('/css/bar.css', $routing->getUrlFor('bar', 'css'));
  }

  public function testGetUrlFor3()
  {
    $routing = new Dynamics_Routing(array(Dynamics_Routing::PATH_DEFAULT=>'/asset/'));
    $this->assertEquals('/asset/foo.js', $routing->getUrlFor('foo', 'js'));
    $this->assertEquals('/asset/bar.css', $routing->getUrlFor('bar', 'css'));
  }

  public function testGetUrlFor4()
  {
    $routing = new Dynamics_Routing(array(Dynamics_Routing::PATH_DEFAULT=>'/asset/', 'js'=>'/js/'));
    $this->assertEquals('/js/foo.js', $routing->getUrlFor('foo', 'js'));
    $this->assertEquals('/asset/bar.css', $routing->getUrlFor('bar', 'css'));
  }
}
