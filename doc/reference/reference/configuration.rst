Dynamics Configuration Options Reference
========================================

How PHP-Dynamics should behave is dictated by an instance of the
``Dynamics_Configuration`` class to which you can pass a wide range of options.

Each option key is a constant defined in Dynamics_Configuration class. If you
want for example to use the MY_OPTION option, you should use:

.. code-block:: php

    <?php
    $configuration = new Dynamics_Configuration(array(
        Dynamics_Configuration::MY_OPTION => 'some value',
    ));

IS_XML_HTTP_REQUEST
:::::::::::::::::::

**Type**: ``boolean``

**Default**: ``false``

Whether or not we're in a XHR context.

.. todo:: document how dynamics use this

GLOBAL_ASSET_PATHS
::::::::::::::::::

**Type**: ``array``

**Default**: ``array()``

**Getter**: ``$configuration->getGlobalAssetPaths()``

Project-wide asset base search path.

.. todo:: explain this in detail, how is exactly resolved this ? Maybe should
   use an "inclusionr reference" to some page describing in detail path
   resolutions in PHP-Dynamics.


RELATIVE_ROOT_URL
:::::::::::::::::

**Type**: ``string``

**Default**: ``''``

Relative root URL, tells dynamics what is base relative URL (without trailing
slash) to access the project wia HTTP. For example, if your homepage is
accessible on http://example.com/my/website/, this option should be set to
'my/website'.

.. todo:: check this is accurate, trailing/leading slash should be crystal
   clear.

WEB_DIR
:::::::

**Type**: ``string``

**Default**: ``''``

Filesystem directory matching the RELATIVE_ROOT_URL. For example, '/var/www'.


.. _reference__configuration__cache_service_class:

CACHE_SERVICE_CLASS
:::::::::::::::::::

**Type**: ``string``

**Default**: ``'Dynamics_Cache_NoCache'``

Cache class name.


.. _reference__configuration__cache_service_options:

CACHE_SERVICE_OPTIONS
:::::::::::::::::::::

**Type**: ``array``

**Default**: ``array()``

Options injected to cache class constructor.

LOADER_SERVICE_CLASS
::::::::::::::::::::

LOADER_SERVICE_OPTIONS
::::::::::::::::::::::

**Type**: ``array``

**Default**: ``array($this, new Dynamics_Callable($this, 'getOption', array(self::IS_XML_HTTP_REQUEST)))``

Options injected to loader class constructor.

RENDERER_SERVICE_CLASS
::::::::::::::::::::::

RENDERER_SERVICE_OPTIONS
::::::::::::::::::::::::

**Type**: ``array``

**Default**: ``array()``

Options injected to renderer class constructor.

ROUTING_SERVICE_CLASS
:::::::::::::::::::::

ROUTING_SERVICE_OPTIONS
:::::::::::::::::::::::

**Type**: ``array``

**Default**: ``array()``

Options injected to routing class constructor.

CONCATENATED_JAVASCRIPT_FILTER_CHAIN
::::::::::::::::::::::::::::::::::::

CONCATENATED_STYLESHEET_FILTER_CHAIN
::::::::::::::::::::::::::::::::::::


