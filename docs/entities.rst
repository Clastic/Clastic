========
Entities
========

.. _overview:

Overview
========

Clastic uses doctrine to handle all data. It also give you an `Node` approach.
Nodes are entities that have basic information.

 - title (string)
 - user (User)
 - create (DateTime)
 - changed (DateTime)
 - publication (NodePublication)
  - available (boolean)
  - publishedFrom (DateTime)
  - publishedTill (DateTime)

.. _create_node:

Create
======

You can use whatever approach you want to generate the base entity. The simplest way is to use
the doctrine generator.

.. code-block:: bash

    php app/console doctrine:generate:entity

Fill in all the field you need.

.. note::

    You don't need to define fields like title, author, ... when you choose to make them Nodes.

Once you created your entity you need to alter the generated code.

Object
~~~~~~

Change the `NodeReferenceInterface` to your freshly generator entity. You can also use the
`NodeReferenceTrait` which helps you implement the interface.

ex:

.. code-block:: php

    <?php
    namespace Clastic\BlogBundle\Entity;

    use Clastic\NodeBundle\Entity\Node;
    use Clastic\NodeBundle\Node\NodeReferenceInterface;

    class Blog implements NodeReferenceInterface
    {
        use NodeReferenceTrait;

        // ...
    }

Definition
~~~~~~~~~~

Add the following code to your xml definition.

.. code-block:: xml

    <many-to-one field="node" target-entity="Clastic\NodeBundle\Entity\Node">
      <cascade><cascade-all/></cascade>
      <join-column name="node_id" referenced-column-name="id" />
    </many-to-one>

