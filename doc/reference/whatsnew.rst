What's new
==========

Version 1.0
:::::::::::

We had to take a few decisions in v.1.0 which makes it a bit incompatible with
older sfDynamicsPlugin versions.

Architecture and refactoring
----------------------------

Some design choice were just bad choices and have been refactored to ebtter
solutions. Concerns are more separated, in different services (instead of a big
ball of mud in the sfDynamicsManager class). This decoupling allows to override
easily some services using your own implementations.

* Cache

  Hey, as you may understand, it manages cache. Hum not really in fact, it
  manages the way should be handled by cache implementations, but Dynamics is
  not a caching library.

  .. todo:: see adequate section

* Loader

  .. todo:: What was it already ?

* Renderer

  View layer. Its work is to write down html, css and javascript.

* Configuration

  Every configurable things goes by this guy.

* Dynamics

  The glue that ties everything together.

Symfony independance
--------------------

First of all, it's now completely independant of symfony. All classes have been
renamed / refactored using PEAR naming standards.

Relative path resolution
------------------------

Path resolutions that were a bit obscure, and symfony dependant. New
implementation tries to find files in the following locations, in order.

* In current file's path.

  For example, speaking about foo/bar.txt in a /path/to/file.xml will try to
  find bar.txt in /path/to/foo/.

* In local resolution path.

  Each XML context can define local resolution paths, which are in their turn
  used relatively to the current file's path.

* In global resolution path

  Additionally, a global resolution path can be configured project wide. To be
  more precise, it's global to one ``Dynamics`` instance.

XML Configuration
-----------------

Assets filenames in xml configuration files are now complete, containing file
extensions.

XML resource import are now working like other file references, using relative
path resolution and containing fil extension.

