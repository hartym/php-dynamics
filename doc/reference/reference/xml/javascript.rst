<javascript> tag
================

Description
:::::::::::

Adds a javascript asset to its parent tag, represented by
:doc:`Dynamics_Configuration_Definition_AssetCollection
</reference/api/Dynamics_Configuration_Definition_AssetCollection>`.

Most probably, this parent will be a :term:`package`, represented by
:doc:`Dynamics_Configuration_Definition_Package
</reference/api/Dynamics_Configuration_Definition_Package>`

Children nodes
::::::::::::::

``<javascript>`` tags cannot have children. 

PHP definition
::::::::::::::

An ``<javascript>`` tag is represented by an instance of
:doc:`Dynamics_Configuration_Definition_Javascript
<reference/api/Dynamics_Configuration_Definition_Javascript>`.

Example
:::::::

.. code-block:: xml

    <javascript>jquery/jquery.js</javascript>

.. seealso:: The :doc:`stylesheet` is very similar to this one.

