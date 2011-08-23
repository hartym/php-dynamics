.. index::
   pair: Architecture; Cache Service

Cache Service
=============

One important part of Dynamics is the cache service. Depending on the
implementation you choose to use, performances can vary a lot.

As it's not dynamics role to provide efficient caching, it only provides an
interface and un dumb "NoCache" implementations. Plugins for ZendFramework,
Symfony, Symfony2, and other frameworks provides adapters that gives Dynamics
the ability to use their clever implementations.

«Program to an interface, not to an implementation» [GoF1]_

Configuration
:::::::::::::

When you create the :apiclass:`Dynamics_Configuration` instance that will be given
to :apiclass:`Dynamics`, you can choose which class will be used as the cache
service by setting the :ref:`reference__configuration__cache_service_class`
option. The only requirement about this class is that it implements
:apiclass:`Dynamics_Cache_Interface` (as shown below).

You can also change its constructor parameters by setting the
:ref:`reference__configuration__cache_service_options` option.

Integration with third party frameworks
:::::::::::::::::::::::::::::::::::::::

.. image:: /_uml/DynamicsCacheUseofthirdparties.png

