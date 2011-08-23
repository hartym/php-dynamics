<?php

class sfDynamicsConfiguration extends Dynamics_Configuration
{
  public function isSupercacheEnabled()
  {
    return sfConfig::get('sf_environment') == 'prod';
  }

  public function isCacheEnabled()
  {
    return true;
  }
}
