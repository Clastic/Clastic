========
Overview
========

Requirements
============

#. PHP 5.4.0
#. Composer
#. nodejs and npm
#. gulp

.. note::

    For detailed instructions on how to install the dependencies. Please refer to google.

.. _installation:

Installation
============

The recommended way to start your projects with `Composer <http://getcomposer.org>`_. Composer is a dependency
management tool for PHP that allows you to declare the dependencies your project needs and installs them into your
project.

If you get an error, remove the word 'php' in front of the line. This depends on your php installation.

.. code-block:: bash

    php composer create-project clastic/standard-edition path/to/install -s dev

During the installation you will be asked to fill in some parameters. Make sure all the values are correct.


Clastic needs multiple assets to be installed in the correct place. The standard project contains a `Makefile`
to simplify this process.

.. code-block:: bash

    make install

You can now start your developement environment.

.. code-block:: bash

    make dev

You can now access your website at http://127.0.0.1:8000/ and the backoffice at http://127.0.0.1:8000/admin/. You can logon using admin as username and secret as password. Note you should immediately change this.

Have fun!

License
=======

Licensed using the `MIT license <http://opensource.org/licenses/MIT>`_.

    Copyright (c) 2015 Dries De Peuter

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.

