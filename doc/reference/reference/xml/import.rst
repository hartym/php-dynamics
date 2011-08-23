<import> tag
============

Description
:::::::::::

``<import>`` tags are used to fetch configuration from other files. Importing
files obey to few rules:

* Imported :term:`packages <package>` replace already configured
  :term:`packages <package>`.

* As all tags refering to a filesystem part, it obeys to the :ref:`relative
  path resolution rules <relative-path-resolution>`

* An ``<import>`` tag will always include only one file, following the previous
  rule.

Children nodes
::::::::::::::

``<import>`` tags cannot have children. 

PHP definition
::::::::::::::

An ``<import>`` tag is taken care about by the parent's ``sfDynamicsConfigDefinition`` instance.

Example
:::::::

.. code-block:: xml

    <import resource="myconfig.xml" />

