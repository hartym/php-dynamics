<?php

/**
 * Dynamics_AssetFilter
 *
 * Defines base requirements (interface) for an asset filter, that is used in
 * an asset filtering filter chain.
 *
 * You must provide a configuration instance reference to the assetfilters
 * constructor. In pre 1.0, sfConfig was used but dynamics is now 100% symfony
 * independant.
 *
 * @package    Dynamics
 * @subpackage AssetFilter
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */

abstract class Dynamics_AssetFilter
{
  /** @var Dynamics_Configuration */
  protected $configuration;

  public function __construct($configuration)
  {
    $this->configuration = $configuration;
  }

  /**
   * Wrapper for doFilter method that tries to hide problems if we're not
   * debugging the application.
   *
   * @param  string $code -- unfiltered code
   * @return string       -- filtered code
   */
  public function filter($code)
  {
    try
    {
      return $this->doFilter($code);
    }
    catch (Exception $e)
    {
      if ($this->configuration->isDebug())
      {
        throw $e;
      }
      else
      {
        return $code;
      }
    }
  }

  /**
   * Abstract code filtering method. Must be implemented in child classes.
   *
   * @param  string $code -- unfiltered code
   * @return string       -- filtered code
   */
  abstract protected function doFilter($code);
}
