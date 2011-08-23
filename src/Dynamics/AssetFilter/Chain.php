<?php

/**
 * Dynamics_AssetFilter_Chain
 *
 * Chain implementation of asset filters.
 *
 * @package    Dynamics
 * @subpackage AssetFilter
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */

class Dynamics_AssetFilter_Chain extends Dynamics_AssetFilter
{
  /**
   * Filter chain
   *
   * @var array
   */
  protected $chain = array();

  /**
   * Instances of filter classes, to avoid instancing multiple times stateless
   * classes.
   *
   * @var array
   */
  protected $filterInstanceCache = array();

  /**
   * Appends a filter to the chain.
   *
   * @param  sfDynamicsBaseAssetFilter $filter
   * @return void
   */
  public function add(Dynamics_AssetFilter $filter)
  {
    $this->chain[] = $filter;
  }

  /**
   * Appends a filter to the chain, given its classname.
   *
   * @param  string $filterClassName
   * @return void
   */
  public function addByName($filterClassName)
  {
    if (!isset($this->filterInstanceCache[$filterClassName]))
    {
      $this->filterInstanceCache[$filterClassName] = new $filterClassName($this->configuration);
    }

    $this->add($this->filterInstanceCache[$filterClassName]);
  }

  protected function doFilter($code)
  {
    foreach ($this->chain as $filter)
    {
      $code = $filter->filter($code);
    }

    return $code;
  }
}

