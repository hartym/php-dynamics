<?php

class sfDynamics
{
  static private $instance;

  static public function setInstance(Dynamics $instance)
  {
    self::$instance = $instance;
  }

  static public function getInstance()
  {
    if (is_null(self::$instance))
    {
      throw new RuntimeException('Not configured.');
    }

    return self::$instance;
  }

  static public function load()
  {
    $inst = self::getInstance();

    foreach (func_get_args() as $arg)
    {
      $inst->load($arg);
    }
  }
}
