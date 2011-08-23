<dynamics> tag
==============

Description
:::::::::::

This is the root node. Each file must have one `dynamics` file and only one,
containing all other tags.

It has no attributes.

.. todo:: No attributes ? this was true till then but maybe local resolution
   path should be there.

Children nodes
::::::::::::::

  * ``<import>``: optional, any number
  * ``<package>``: optional, any number

PHP definition
::::::::::::::

The <dynamics> tags are managed by one instance of
``sfDynamicsConfigDefinition`` that will merge all root tags of the different
XML configuration files included.

Example
:::::::

.. code-block:: xml

    <?xml version="1.0" ?>
    <dynamics>
        <import resource="jquery/jquery.xml" />
        <package name="eat-at-joe">
            <require>jquery</require>
            <javascript>joe-s-ad.js</javascript>
        </package>
    </dynamics>

