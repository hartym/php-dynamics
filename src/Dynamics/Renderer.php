<?php

/**
 * Dynamics_Renderer
 *
 * XXX old doc :
 * sfDynamicsRenderer - Assets renderer. Manage minifying and grouping.
 *
 * @package    Dynamics
 * @subpackage Renderer
 * @author     Romain Dorgueil <romain@dorgueil.net>
 * @license    WTFPL
 */
class Dynamics_Renderer
{
    /** @var Dynamics_Configuration */
    protected $configuration;

    /** @var Dynamics_Routing */
    protected $routing;

    /** @var array */
    protected $javascripts = array();

    /** @var array */
    protected $stylesheets = array();

    /**
     * Constructor.
     */
    public function __construct($configuration, $routing)
    {
        $this->configuration = $configuration;
        $this->routing = $routing;
    }

    /**
     * Renders the HTML asset inclusion tags (script and link tags).
     *
     * TODO explosion of asset name can be done while generating cache.
     */
    public function render($packages, $types=array(Dynamics::STYLESHEET, Dynamics::JAVASCRIPT))
    {
        $html = PHP_EOL;

        foreach ($types as $type)
        {
            $extension = Dynamics::getExtensionFromType($type);

            if ($this->configuration->isSupercacheEnabled())
            {
                // TODO FIXME
                $url = $this->routing->getCacheUrlFor($packages, $extension);
                if ($this->generateSupercache($url, $packages, $type))
                {
                    $html .= '    '.$this->getTag($url, $type)."\n";
                }
            }
            else
            {
                foreach ($packages as $packageName => $package)
                {
                    $assets = $package->{'get'.ucfirst($type).'s'}();
                    if (count($assets))
                    {
                        $html .= '    '.$this->getTag($this->routing->getUrlFor($packageName, $extension), $type).PHP_EOL;
                    }
                }
            }
        }

        return $html;
    }

    public function getTag($url, $type)
    {
        switch ($type)
        {
            case 'javascript':
                return '<script type="text/javascript" src="'.$url.'"></script>';
            case 'stylesheet':
                return '<link rel="stylesheet" type="text/css" media="all" href="'.$url.'" />';
            default:
                throw new InvalidArgumentException('Invalid asset type.');
        }
    }

    /**
     * getAsset - render assets of a given type for a package
     *
     * @param  string                              $name
     * @param  sfDynamicsAssetCollectionDefinition $package
     * @param  string                              $type
     * @return string
     */
    public function getAsset($name, Dynamics_Configuration_Definition_AssetCollection $package, $type)
    {
        $extension = Dynamics::getExtensionFromType($type);
        $getAssets = 'get'.ucfirst($type).'s';

        if (count($assets = $package->$getAssets()))
        {
            $paths = $package->getPaths($this->configuration->getGlobalAssetPaths());

            if ($this->configuration->isCacheEnabled())
            {
                $cache = $this->configuration->getCacheService();
                $cacheKey = $cache->generateKey($package, $type);

                if ($cache->has($cacheKey))
                {
                    if ($this->configuration->isCacheUpToDateCheckEnabled())
                    {
                        if ($cache->isStillUpToDate($package, $type, $cacheKey))
                        {
                            $result = $cache->get($cacheKey);
                        }
                    }
                    else
                    {
                        $result = $cache->get($cacheKey);
                    }
                }
            }

            // still no result? let's build it!
            if (!isset($result))
            {
                $result = $this->configuration
                    ->getConcatenatedAssetFilterChainFor($type)
                    ->filter($this->getConcatenatedAssets($package, $paths, $assets));

                if ($this->configuration->isCacheEnabled())
                {
                    $cache->set($cacheKey, $result);
                }
            }

            return $result;
        }
        else
        {
            return '';
        }

    }

    /**
     * getConcatenatedAssets - Packs a list of assets in one string
     */
    protected function getConcatenatedAssets($package, array $paths, array $assets)
    {
        $result = '';
        $attempts = array();

        foreach ($assets as $asset)
        {
            $result .= $asset->getFilteredContent($package)."\n";
        }

        return $result;
    }

    /**
     * generateSupercache - creates supercache file for given packages
     */
    public function generateSupercache($url, $packages, $type)
    {
        if (!$this->configuration->isSupercacheEnabled())
        {
            throw new BadMethodCallException('Supercache is disabled.');
        }

        if (!file_exists($filename = $this->configuration->getOption(Dynamics_Configuration::WEB_DIR).$url))
        {
            $src = '';

            foreach ($packages as $name => $package)
            {
                if ($renderedSrc = trim($this->getAsset($name, $package, $type)))
                {
                    $src .= '/* '.$name.' */ '.$renderedSrc."\n";
                }
            }

            if (strlen($src))
            {
                file_put_contents($filename, $src);

                if (!file_exists($filename))
                {
                    throw new Exception('Supercache could not be written: '.$filename);
                }

            }
            else
            {
                return false;
            }
        }

        return true;
    }
}

# vim: et ts=4 sw=4
