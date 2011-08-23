<?php

class Dynamics_Configuration
{
    const IS_XML_HTTP_REQUEST = 'is_xml_http_request';
    const GLOBAL_ASSET_PATHS = 'global_asset_paths';
    const RELATIVE_ROOT_URL = 'relative_root_url';
    const WEB_DIR = 'web_dir';
    const CACHE_SERVICE_CLASS = 'cache_service_class';
    const CACHE_SERVICE_OPTIONS = 'cache_service_options';
    const LOADER_SERVICE_CLASS = 'loader_service_class';
    const LOADER_SERVICE_OPTIONS = 'loader_service_options';
    const RENDERER_SERVICE_CLASS = 'renderer_service_class';
    const RENDERER_SERVICE_OPTIONS = 'renderer_service_options';
    const ROUTING_SERVICE_CLASS = 'routing_service_class';
    const ROUTING_SERVICE_OPTIONS = 'routing_service_options';
    const CONCATENATED_JAVASCRIPT_FILTER_CHAIN = 'concatenated_javascript_filter_chain';
    const CONCATENATED_STYLESHEET_FILTER_CHAIN = 'concatenated_stylesheet_filter_chain';

    /** @var array */
    protected $default_options;

    protected
        $options,
        $definition = null,
        $cache = null,
        $routing = null,
        $loader = null,
        $renderer = null,
        $concatenatedAssetFilterChainCache = array();

    public function __construct($options = array())
    {
        $this->default_options = array(
                self::IS_XML_HTTP_REQUEST => false,
                self::GLOBAL_ASSET_PATHS => array(),
                self::RELATIVE_ROOT_URL => '',
                self::WEB_DIR => null,
                self::CACHE_SERVICE_CLASS => 'Dynamics_Cache_NoCache',
                self::CACHE_SERVICE_OPTIONS => array(
                    ),
                self::LOADER_SERVICE_CLASS => 'Dynamics_Loader',
                self::LOADER_SERVICE_OPTIONS => array(
                        $this,
                    ),
                self::RENDERER_SERVICE_CLASS => 'Dynamics_Renderer',
                self::RENDERER_SERVICE_OPTIONS => array(
                        $this,
                        new Dynamics_Callable($this, 'getRoutingService')
                    ),
                self::ROUTING_SERVICE_CLASS => 'Dynamics_Routing',
                self::ROUTING_SERVICE_OPTIONS => array(
                        $this,
                    ),
                self::CONCATENATED_JAVASCRIPT_FILTER_CHAIN => array(),
                self::CONCATENATED_STYLESHEET_FILTER_CHAIN => array(),
            );

        $this->options = $options;
    }

    public function getGlobalAssetPaths()
    {
        return $this->getOption(self::GLOBAL_ASSET_PATHS);
    }

    public function loadFromXml($path, $xml)
    {
        $this->definition = new Dynamics_Configuration_Definition_Dynamics($path, $xml);
    }

    public function loadFromFiles($filenames = array())
    {
        if (empty($filenames))
        {
            return;
        }

        $filename = array_pop($filenames);

        if (file_exists($filename))
        {
            if (!(is_file($filename) && is_readable($filename)))
            {
                throw new sfException('Configuration file '.$filename.' is present but not readable or not a regular file.');
            }
        }

        $this->loadFromXml(realpath(dirname($filename)), simplexml_load_file($filename));
    }

    public function isCacheEnabled()
    {
        return true;
    }

    public function isSupercacheEnabled()
    {
        return true;
    }

    public function getPackage($name)
    {
        return $this->definition->getPackage($name);
    }

    public function getOption($key)
    {
        if (array_key_exists($key, $this->options))
        {
            return $this->options[$key];
        }
        elseif (array_key_exists($key, $this->default_options))
        {
            return $this->default_options[$key];
        }

        throw new Dynamics_Error_InvalidOption($key);
    }

    public function setOption($key, $value, $offset=null)
    {
        if (is_null($offset))
        {
            $this->options[$key] = $value;
        }
        else
        {
            if (!isset($this->options[$key]))
            {
                $this->options[$key] = $this->default_options[$key];
            }

            $this->options[$key][$offset] = $value;
        }
    }

    public function getService($serviceName)
    {
        if (is_null($this->$serviceName))
        {
            $serviceClass = $this->getOption(constant(sprintf('self::%s_SERVICE_CLASS', strtoupper($serviceName))));
            $serviceOptions = $this->getOption(constant(sprintf('self::%s_SERVICE_OPTIONS', strtoupper($serviceName))));

            // resolve lazy parameters
            foreach ($serviceOptions as $index => $option)
            {
                if ($option instanceof Dynamics_Callable)
                {
                    $serviceOptions[$index] = $option->call();
                }
            }

            $serviceReflection = new ReflectionClass($serviceClass);
            $this->$serviceName = $serviceReflection->newInstanceArgs($serviceOptions);
        }

        return $this->$serviceName;
    }

    public function getRoutingService()
    {
        return $this->getService('routing');
    }

    public function getRendererService()
    {
        return $this->getService('renderer');
    }

    public function getCacheService()
    {
        return $this->getService('cache');
    }

    public function getLoaderService()
    {
        return $this->getService('loader');
    }

    /**
     * Generates or retrieve from cache the filter chain object for given type.
     *
     * xxx test
     *
     * @param string $type  --  Asset type (javascript, stylesheet).
     */
    public function getConcatenatedAssetFilterChainFor($type)
    {
        if (!isset($this->concatenatedAssetFilterChainCache[$type]))
        {
            $this->concatenatedAssetFilterChainCache[$type] = new Dynamics_AssetFilter_Chain($this);
            $config = $this->getOption(constant('self::CONCATENATED_'.strtoupper($type).'_FILTER_CHAIN'));

            foreach ($config as $filterClassName)
            {
                $this->concatenatedAssetFilterChainCache[$type]->addByName($filterClassName);
            }
        }

        return $this->concatenatedAssetFilterChainCache[$type];
    }
}

# vim: et ts=4 sw=4
