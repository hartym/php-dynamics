<?php
require_once dirname(__FILE__).'/../../../src/php-dynamics/Dynamics/AssetFilter.php';

/**
 * Concrete implementation of the abstract Dynamics_AssetFilter
 */
class Dynamics_AssetFilter_Concrete extends Dynamics_AssetFilter
{
    protected function doFilter($code)
    {
        return $code.' filtered';
    }
}

/**
 * Concrete implementation of the abstract Dynamics_AssetFilter
 */
class Dynamics_AssetFilter_BuggyConcrete extends Dynamics_AssetFilter
{
    protected function doFilter($code)
    {
        throw new Exception();
    }
}

/**
 * Minimal implementation of configuration.
 */
class Dynamics_Configuration_Mock
{
    public function isDebug()
    {
        return true;
    }
}

class Dynamics_AssetFilter_Test extends PHPUnit_Framework_TestCase
{
    public function testFiltering()
    {
        $filter = new Dynamics_AssetFilter_Concrete(new Dynamics_Configuration_Mock());
        $this->assertEquals('test filtered', $filter->filter('test'));
    }

    /**
     * @expectedException Exception
     */
    public function testBuggyFiltering()
    {
        $filter = new Dynamics_AssetFilter_BuggyConcrete(new Dynamics_Configuration_Mock());
        $result = $filter->filter('test');
    }
}

# vim: et ts=4 sw=4
