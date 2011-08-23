Installation
============

PHP Dynamics is a plain PHP library, which has a very few dependencies. In
fact, the only dependency is PHP 5.2.

Get the source
::::::::::::::

Use the SCM
-----------

We're using git:

.. code-block:: sh

    git clone git://github.com/hartym/php-dynamics.git lib/vendor/php-dynamics

You can also use it as a submodule (change lib/vendor by the path you choose
for your external libraries):

.. code-block:: sh

    git submodule add git://github.com/hartym/php-dynamics.git lib/vendor/php-dynamics
    git submodule init
    git submodule update

.. todo::

    Push code to repo. We may need to change repo list, because, I don't want
    doc + tests + xxx to be mandatorily included in projects using dynamics.
    One good looking solution can be having only php-dynamics code in the
    php-dynamics repo, and having this as a submodule in php-dynamics-full
    repository.

Use PEAR
--------

If you prefer to use pear, you need to add our pear channel::

    pear channel-discover pear.dakrazy.net
    pear install php-dynamics

PEAR channel is powered by `pirum <http://www.pirum-project.org/>`_.

.. todo::

    PEAR channel is not up yet.

Use a tarball
-------------

For most uses, above solutions are enough. If for one reason it's not your
case, releases tarballs are available too.

.. todo::

    Make tarball releases.

Project setup
:::::::::::::

.. note::

    For framework specific instructions, see
    :doc:`integration/symfony/install`, :doc:`integration/symfony2/install` and
    :doc:`integration/zend/install`. If you did write some instructions or code
    to integrate it within another framework, feel free to write a patch and
    make a pull request.

Before you get started, it's important to understand that php-dynamics does not
make any assumption about how your project is structured, and nothing is really
imposed. We will get you started here by suggesting defaults, but once you've
understood the underlying mechanics, you can adapt it as you like.

For this basic setup, we will assume your project looks like the following:

* **/lib**

  * **/vendor**

    * **/php-dynamics**

      Library directory, retrieved using either of above source retrieval
      methods.

* **/config**

  Your configuration directory.

* **/web**

  Your webserver public directory. We'll assume your webserver is
  apache-like, and we assume you're adapt this tutorial if you setup up some
  strange looking webserver.

General architecture
--------------------

PHP-Dynamics is composed of two major visible subsystems.

* The **dynamics front controller** which will serve dynamically generated
  javascripts and stylesheets.

  This will most probably seen as a *dynamics.php* file under your public
  webserver directory. It's up to you to name it differently, and you'll most
  probably be hiding it using some URL rewriting mechanism.

* The **dependency resolver** which you'll use in your application to know
  which javascripts and stylesheets your html should require. Some helpers are
  available to add the markup too, but that's just a little candy.

  Your entry point to this subsystem will be a configured instance of the
  :doc:`Dynamics <reference/Dynamics>` class.

Additionaly, PHP-Dynamics needs some configuration to know what to serve.

Dynamics front-controller
-------------------------

Let's create a *web/dynamics.php* file containing the following.

.. code-block:: php

    <?php

    require_once dirname(__FILE__).'/../lib/vendor/php-dynamics/Dynamics/Autoloader.php';
    Dynamics_Autoloader::register();

    echo Dynamics_MiniWeb::run(array(dirname(__FILE__).'/../config/dynamics.xml'));

The only interesting stuff for you now is the array of filenames passed to the
*Dynamics_MiniWeb* component. It's the dynamics configuration files that will
be used to do package to assets resolution.

.. seealso::

   * :doc:`reference/Dynamics_Autoloader`
   * :doc:`reference/Dynamics_Miniweb`

Configuration
-------------

Dynamics configuration is made of XML files, describing :term:`packages
<package>`. Let's write the (second) simplest configuration file in the world:

.. code-block:: xml

    <?xml version="1.0" ?>
    <dynamics>
        <package name="foo">
            <stylesheet>bar.css</stylesheet>
        </package>
    </dynamics>

Save this file in *config/dynamics.xml*.

Before we can actually try to get our package's content via dynamics front
controller, we have to write a bit of CSS too. Create a *config/bar.css* file
with the following content (for example).

.. code-block:: css

    .foo {
        border: 1px solid blue;
    }

.. note::

    CSS/JS/XML path resolution is done relatively to the xml file referencing
    it. This is overridable in each XML file, and we don't advice you put the
    CSS/JS file in your config folder, but for now, we'll try to keep the
    easiest setup possible.

Try accessing http://localhost/dynamics.php/foo.css to be certain it's
actually working (change "localhost" to match your actual webserver setup).

.. note::

    You may notice a difference between your source, and the actual generated
    source. It's because source code is going thru filter chains, that can make
    some changes.

    For now, it's not very important to understand this.

.. seealso::

   * :doc:`configuration/xml/reference/dynamics`
   * :doc:`configuration/xml/reference/package`
   * :doc:`configuration/xml/reference/stylesheet`

Dynamics Dependency Resolver
----------------------------

The really interesting part is now coming.

Concept
.......

What you want to be able to do, is write code looking like this.

.. code-block:: php

    <?php

    class MyAwesomeApp_Controller extends MyAwesomeFramework_Controller {
        public function indexAction($request) {
            $dynamics = ...;
            $dynamics->load('foo');
        }
    }

And some template...

.. code-block:: html+php

    <html>
      <head>
        <?php $dynamics->render(); ?>
      </head>
      <body>
        <h1>Welcome</h1>
        <div class="foo">
          <?php echo $content; ?>
        </div>
      </body>
    </html>

Expected result is to have javascripts and stylesheets needed by the 'foo'
package and its dependencies included, in the right order.

.. note::

    This code sample is a schema, but should be pretty straightforward to adapt
    to any framework. The only hard stuff here is to know what to put as a
    value for $dynamics. This should be an instance of Dynamics class, which
    took a Dynamics_configuration instance as its first parameter.

    Depending on your conventions and tools, there are many ok way to do this,
    but remember that:

    * There should be only one copy of the code.
    * There should be only one instance, request-wise.

In practice
...........

Let's write the following *web/index.php* file (It's up to you to adapt the
code to your own code organization, our goal here is to make it the simplest
possible).

.. code-block:: php

    <?php
    require_once dirname(__FILE__).'/../lib/vendor/php-dynamics/Dynamics/Autoloader.php';
    Dynamics_Autoloader::register();

    $configuration = new Dynamics_Configuration();
    $configuration->loadFromFiles(array(dirname(__FILE__).'/../config/dynamics.xml'));

    $dynamics = new Dynamics($configuration);
    $dynamics->load('foo');
    ?>

.. code-block:: html+php

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
      <head>
        <?php echo $dynamics->render(); ?>
      </head
      <body>
        <div class="foo">
          I'm a foo.
        </div>
      </body>
    </html>

If you open http://localhost/index.php (or whatever your virtualhost is), you
should now see the following:

.. image:: /images/figures/install.1.png

Summary
:::::::

That's it, your first PHP-Dynamics project is up and running. It does not do
many things, but base concepts are there.
