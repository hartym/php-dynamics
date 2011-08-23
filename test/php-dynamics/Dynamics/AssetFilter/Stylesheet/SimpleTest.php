<?php
require_once dirname(__FILE__).'/../../../../../src/php-dynamics/Dynamics/AssetFilter.php';
require_once dirname(__FILE__).'/../../../../../src/php-dynamics/Dynamics/AssetFilter/Stylesheet/Simple.php';

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

class Dynamics_AssetFilter_Stylesheet_Simple_Test extends PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $configuration = new Dynamics_Configuration_Mock();
        $filter = new Dynamics_AssetFilter_Stylesheet_Simple($configuration);
        $this->assertEquals(' div.verylarge { background-image: url("image.jpg"); } ', $filter->filter('

            div.verylarge     {

                background-image: url("image.jpg");
            }

        '));
    }
}

# vim: et ts=4 sw=4

