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

:q

Dynamics Cache architecture
:::::::::::::::::::::::::::

.. todo:: diagram

Integration with third party frameworks
:::::::::::::::::::::::::::::::::::::::

.. image:: /_uml/DynamicsCacheUseofthirdparties.png

