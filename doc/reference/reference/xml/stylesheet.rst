<stylesheet> tag
================

Description
:::::::::::

Adds a stylesheet asset to its parent tag, represented by
:doc:`Dynamics_Configuration_Definition_AssetCollection
</reference/api/Dynamics_Configuration_Definition_AssetCollection>`.

Most probably, this parent will be a :term:`package`, represented by
:doc:`Dynamics_Configuration_Definition_Package
</reference/api/Dynamics_Configuration_Definition_Package>`

Children nodes
::::::::::::::

``<stylesheet>`` tags cannot have children. 

PHP definition
::::::::::::::

An ``<stylesheet>`` tag is represented by an instance of
:doc:`Dynamics_Configuration_Definition_Stylesheet
<reference/api/Dynamics_Configuration_Definition_Stylesheet>`.

Example
:::::::

.. code-block:: xml

    <stylesheet>css/amazing.css</stylesheet>

.. seealso:: The :doc:`javascript` is very similar to this one.

