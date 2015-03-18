=======
Modules
=======

.. _overview:

Overview
========

Clastic uses modules to expose data to the backend.


.. _create:

To generate a module you must first create an entity.

.. code-block:: bash

    php app/console doctrine:generate:entity

Fill in all the field you need.

.. note::

    You don't need to define fields like title, author, ... when you choose to make them Nodes.

Once you created your entity you can generate your module.

.. code-block:: bash

    php app/console clastic:generate:module

After generation your modules will be available in the backoffice.

