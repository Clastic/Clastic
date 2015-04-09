===============
Contrib Bundles
===============

.. _overview:

Overview
========

Clastic is composed of different bundles all serving a single purpose. Not all features are provided by the
core installation. Clastic has a set of bundles that are not for the general public, but may be useful for you.

You can find these bundles at `the clastic contrib page <https://github.com/Clastic-Contrib/>`_.

.. _publish:

Publishing
==========

Sharing bundles with others is a nice thing to do. If you would like your bundle to be featured in the contrib
list, create an issue in the `issue queue <https://github.com/Clastic/Clastic/issues>`_. Your bundle will than
be evaluated by the Clastic team. If the bundle is approved you can tranfer ownership of the bundle. You will
than be part of the Clastic team and will be promoted as maintainer of the bundle.

Naming
~~~~~~

.. note::

    Please don't use ``clastic`` as the vendor name before your package has been approved.

Say you are building a catalog module. Don't use ``clastic/catalog-bundle`` in the ``composer.json``. Keep your
package under your own vendor name (``myname/catalog-bundle``). Once accepted you can choose to change or keep
the name of the package.
