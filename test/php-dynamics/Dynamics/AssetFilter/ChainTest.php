<?php
require_once dirname(__FILE__).'/../../../../src/php-dynamics/Dynamics/AssetFilter.php';
require_once dirname(__FILE__).'/../../../../src/php-dynamics/Dynamics/AssetFilter/Chain.php';

/**
 * Concrete implementation of the abstract Dynamics_AssetFilter
 */
class Dynamics_AssetFilter_Concrete_1 extends Dynamics_AssetFilter
{
    protected function doFilter($code)
    {
        return $code.' 1';
    }
}

class Dynamics_AssetFilter_Concrete_2 extends Dynamics_AssetFilter
{
    protected function doFilter($code)
    {
        return $code.' 2';
    }
}

class Dynamics_AssetFilter_Chain_Test extends PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $configuration = new Dynamics_Configuration_Mock();
        $filter = new Dynamics_AssetFilter_Chain($configuration);
        $this->assertEquals('test', $filter->filter('test'));
        $filter->add(new Dynamics_AssetFilter_Concrete_1($configuration));
        $filter->add(new Dynamics_AssetFilter_Concrete_2($configuration));
        $this->assertEquals('test 1 2', $filter->filter('test'));
    }

    public function testAddByName()
    {
        $configuration = new Dynamics_Configuration_Mock();
        $filter = new Dynamics_AssetFilter_Chain($configuration);
        $this->assertEquals('test', $filter->filter('test'));
        $filter->addByName('Dynamics_AssetFilter_Concrete_1');
        $this->assertEquals('test 1', $filter->filter('test'));
        $filter->addByName('Dynamics_AssetFilter_Concrete_1');
        $this->assertEquals('test 1 1', $filter->filter('test'));
        $filter->addByName('Dynamics_AssetFilter_Concrete_2');
        $filter->addByName('Dynamics_AssetFilter_Concrete_1');
        $this->assertEquals('test 1 1 2 1', $filter->filter('test'));
    }

    public function createConfiguration()
    {
        return $this->getMock('Dynamics_Configuration', array('isDebug'));
    }
}

# vim: et ts=4 sw=4
