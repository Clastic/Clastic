============
Installation
============

.. _preparations:

Preparations
============

Clastic has a few dependencies to get the project up-and-running.

 - PHP ~5.4
 - Composer
 - node.js
 - npm
 - gulp
 - bower

For detail information about the dependencies see the `Installing dependencies`_ section.

.. _create_a_project:

Create a project
================

The recommended way to start your projects with `Composer <http://getcomposer.org>`_. Composer is a dependency
management tool for PHP that allows you to declare the dependencies your project needs and installs them into your
project.

If you get an error, remove the word 'php' in front of the line. This depends on your php installation.

.. code-block:: bash

    $ composer create-project clastic/standard-edition path/to/install -s dev

.. note::

    If the installation fails, check if the ``composer`` executable works. You might need to
    use ``php composer.phar create-project path/to/install -s dev`` if you installed composer locally.

During the installation you will be asked to fill in some parameters. Make sure all the values are correct.

You should now have a project located in ``path/to/install``. Please go to this folder and continue.

.. code-block:: bash

    $ cd path/to/install

Clastic needs multiple assets to be installed in the correct place. The standard project contains a `Makefile`
to simplify this process.

.. code-block:: bash

    make install

.. note::

    Now is a good time to have a first commit!

.. _development:

Development
-----------

You can now start your development environment.

.. code-block:: bash

    $ make dev

You can now access your website at http://127.0.0.1:8000/ and the backoffice at http://127.0.0.1:8000/admin/.
You can logon using admin as username and secret as password. Note you should immediately change this.

Have fun!

.. _production:

Production
==========

For any information about setting up a production server. Please refer to
the `symfony documentation <http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html>`_.

.. _installing_dependencies:

Installing dependencies
=======================

PHP
---

To install PHP refer to your option of choice. Installation instructions are different for every platform.
See the `PHP Installation Guide<http://php.net/manual/en/install.php>`_. Make sure your PHP version is higher than
`5.4.0`.

Composer
--------

Composer is a dependency manager for PHP.

Use the following code to install, see the `Official installation documentation<https://getcomposer.org/download/>`_
for detailed information.

.. code-block:: bash

    $ curl -sS https://getcomposer.org/installer | php

Node.js
-------

Install node.js using the official installers available at `<https://nodejs.org/download/>`_.

NPM
---

Npm comes included with node.js.

Gulp
----

Gulp is a streaming build system. It is used to build assets.

Use the following code to install, see the `Official installation documentation<https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md>`_
for detailed information.

.. code-block:: bash

    $ npm install --global gulp

Bower
-----

Use the following code to install, see the `Official installation documentation<http://bower.io/#install-bower>`_
for detailed information.

.. code-block:: bash

    $ npm install -g bower

