=======
Bundles
=======

.. _overview:

Overview
========

Clastic is composed of different modules all serving a single purpose.

.. _core_bundle:

Base Bundles
============

Core
~~~~

The core bundle is heart of the framework. It defines the basic flow and dependencies.

Backoffice
~~~~~~~~~~

The backoffice bundle contains the basic features of the backoffice including the form types.

 - `DatePicker`_
 - `EntityHidden`_
 - `EntityMultiSelect`_
 - `Fieldset`_
 - `Link`_
 - `MultiSelect`_
 - `Tree`_
 - `Wysiwyg`_

.. _DatePicker: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/DatePickerType.php
.. _EntityHidden: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/EntityHiddenType.php
.. _EntityMultiSelect: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/EntityMultiSelectType.php
.. _Fieldset: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/FieldsetType.php
.. _Link: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/LinkType.php
.. _MultiSelect: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/MultiSelectType.php
.. _Tree: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/TreeType.php
.. _Wysiwyg: https://github.com/Clastic/BackofficeBundle/blob/master/Form/Type/WysiwygType.php

User
~~~~

The user bundle provides everything to manage users.

Security
~~~~~~~~

The security bundle adds security to the backoffice.

Node
~~~~

The node bundle provides extra metadata for your data. It allows other bundles to dynamically extend your data.

Front
~~~~~

The front bundle provides basic features for the public side of your application.

Feature Bundles
===============

Alias
~~~~~

The alias bundle provides aliases for your nodes. This will allow you to create a user-friendly url for every node.

Block
~~~~~

The block bundle provides an easy interface for developers to allow administrators to change non-content with ease.

Taxonomy
~~~~~~~~

The taxonomy bundle provides basic tools to simplify creation of nested and sortable content.

Module Bundles
==============

Blog
~~~~

The blog bundle provides a simple module to create a very basic blog.

Media
~~~~~

The media bundle provides basic tools to handle media in your application.

Menu
~~~~

The menu bundle provides a module to handle your menu structures.

Text
~~~~

The text bundle provides a module to create simple content pages.

Tool Bundles
============

Generator
~~~~~~~~~

The generator bundle provides a generator to increase development times.

Contrib Bundles
===============

You can find more bundles in the :doc:`contrib`.