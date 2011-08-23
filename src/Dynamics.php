<?php
/**
 * @package   php-dynamics
 * @copyright Copyright (C) Romain Dorgueil
 * @author    Romain Dorgueil <romain@dorgueil.net>
 * @license   WTFPL
 */

class Dynamics
{
    const JAVASCRIPT = 'javascript';
    const STYLESHEET = 'stylesheet';
    const JAVASCRIPT_EXTENSION = 'js';
    const STYLESHEET_EXTENSION = 'css';

    /** @var Dynamics_Cache */
    protected $cache = null;

    /** @var Dynamics_Configuration */
    protected $configuration = null;

    /** @var Dynamics_Loader */
    protected $loader = null;

    /** @var Dynamics_Renderer */
    protected $renderer = null;

    static public function getTypeFromExtension($extension)
    {
        switch ($extension)
        {
            case self::JAVASCRIPT_EXTENSION: return self::JAVASCRIPT;
            case self::STYLESHEET_EXTENSION: return self::STYLESHEET;
        }

        throw new Dynamics_Error_InvalidAssetType();
    }

    static public function getExtensionFromType($type)
    {
        switch ($type)
        {
            case self::JAVASCRIPT: return self::JAVASCRIPT_EXTENSION;
            case self::STYLESHEET: return self::STYLESHEET_EXTENSION;
        }

        throw new Dynamics_Error_InvalidAssetType();
    }

    /**
     * Constructor.
     *
     * @param  Dynamics_Configuration $configuration
     */
    public function __construct(Dynamics_Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->setup();
    }

    /**
     * Setup method is here to allow subclasses to bring their behavior in.
     *
     * @return void
     */
    protected function setup()
    {
    }

    /**
     * Loads a bunch of packages, and their dependencies.
     */
    public function load()
    {
        $this->loadArray(func_get_args());
    }

    /**
     * Loads a bunch of packages, and their dependencies.
     *
     * @param  array $packages
     * @return void
     */
    public function loadArray(array $packages)
    {
        $loader = $this->configuration->getLoaderService();

        foreach($packages as $package)
        {
            $loader->load($package);
        }
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function render()
    {
        $loader = $this->configuration->getLoaderService();
        $renderer = $this->configuration->getRendererService();

        return $renderer->render($loader->getPackages());
    }
}

# vim: et ts=4 sw=4
