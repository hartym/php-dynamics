Architecture
============

Overview
::::::::

.. index::
   single: Architecture; Overview

Dynamics class
::::::::::::::

Configuration
:::::::::::::

The cache service
:::::::::::::::::

.. index::
   single: Architecture; Cache Overview

PHP-Dynamics Cache Service is pretty simplistic. It only provides an interface,
:apiclass:`Dynamics_Cache_Interface`, and anything implementing it can be used
as a Dynamics cache backend.

.. image:: /_uml/DynamicsCacheService.png

PHP-Dynamics does not provide any real world implementation for this, and is using
the mock implementation :apiclass:`Dynamics_Cache_NoCache` by default.

.. note::

    If you don't have a cache backend implementation in your current framework,
    you can use :doc:`existing adapters for major PHP frameworks
    </integration/index>`.

.. seealso:: :doc:`cache`

The loader service
::::::::::::::::::

The renderer service
::::::::::::::::::::

