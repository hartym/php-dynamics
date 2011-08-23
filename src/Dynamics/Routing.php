<?php

/**
 * Dynamics_Routing
 *
 * Base class to translate an asset into URLs. The only little difficulty here
 * is that depending on setup (are we using a framework? Are we using the
 * "miniweb" setup? Are we using URL rewriting?), paths are not at all the same.
 *
 * By default, the only created instance is created by the
 * Dynamics_Configuration instance, but you can create it manually to change
 * parameters.
 *
 * XXX not really good because if you setup manually, not anymore lazy loaded.
 * Need to address this (generic getService/setService to setup
 * constructor/classname ?)
 *
 * @package    PHPDynamics
 * @subpackage Routing
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */
class Dynamics_Routing
{
    const PATH_DEFAULT = '__default__';

    /** @var Dynamics_Configuration */
    protected $configuration;

    /** @var array */
    protected $paths = array(
            self::PATH_DEFAULT => '/dynamics.php/'
        );

    /**
     * Constructor.
     *
     * @param array $paths  --  Web paths indexed by asset extension. Default to
     *                          '/dynamics.php' for every asset type.
     */
    public function __construct($configuration, $paths = null)
    {
        $this->configuration = $configuration;

        if (is_array($paths))
        {
            foreach ($paths as $extension => $path)
            {
                $this->paths[$extension] = $path;
            }
        }

        $this->setup();
    }

    public function setup()
    {
    }

    /**
     * Returns an asset web url. Depending on how the class was configured, paths
     * can be different depending on the asset extension.
     *
     * @param string $name       --  The asset filename, wihtout extension.
     * @param string $extension  --  The asset extension (no dot).
     */
    public function getUrlFor($name, $extension)
    {
        if (isset($this->paths[$extension]))
        {
            return $this->paths[$extension].$name.'.'.$extension;
        }
        elseif (isset($this->paths[self::PATH_DEFAULT]))
        {
            return $this->paths[self::PATH_DEFAULT].$name.'.'.$extension;
        }

        return $asset;
    }

    /**
     * XXX write, test, use, document ...
     */
    public function getCacheUrlFor($packages, $extension)
    {
        $cacheKey = '';

        foreach ($packages as $package)
        {
            $cacheKey .= $package->getCacheKey();
        }

        return $this->configuration->getOption(Dynamics_Configuration::RELATIVE_ROOT_URL).$this->getUrlFor(md5($cacheKey), $extension);
    }
}

# vim: et ts=4 sw=4
