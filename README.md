Clastic Development
===================

 [![Build Status](https://img.shields.io/travis/Clastic/Clastic.svg?style=flat-square)](https://travis-ci.org/Clastic/Clastic)
 [![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

This project should only be used for development.

# Requirements

You need the following installed globally on your system:
 - [composer](http://getcomposer.org)
 - [nodejs and npm](http://nodejs.org)
 - [gulp](http://gulpjs.com)

# Installation

First [fork](https://github.com/Clastic/Clastic/fork) the project.

1. Clone the project

    ```
    $ git clone git@github.com:[you]/Clastic.git
    $ cd Clastic
    $ git remote add upstream git@github.com:Clastic/Clastic.git
    ````

2. Install

    ```
    $ make install
    ```

3. Setup development env

    ```
    $ make dev
    ```

# Update

1. Update your source

    ```
    $ git fetch upstream
    $ git checkout master
    $ git rebase upstream/master
    ```

2. Setup new assets

    ```
    $ make update
    ```

3. Start development env

    ```
    $ make dev
    ```
Contributing
------------

> All code contributions - including those of people having commit access - must
> go through a pull request and approved by a core developer before being
> merged. This is to ensure proper review of all the code.
>
> Fork the project, create a feature branch, and send us a pull request.
>
> To ensure a consistent code base, you should make sure the code follows
> the [Coding Standards](http://symfony.com/doc/2.0/contributing/code/standards.html)
> which we borrowed from Symfony.
> Make sure to check out [php-cs-fixer](https://github.com/fabpot/PHP-CS-Fixer) as this will help you a lot.

If you would like to help, take a look at the [list of issues](http://github.com/Clastic/Clastic/issues).

Requirements
------------

PHP 5.3.2 or above

Author and contributors
-----------------------

Dries De Peuter - <dries@nousefreak.be> - <http://nousefreak.be>

See also the list of [contributors](https://github.com/Clastic/Clastic/contributors) who participated in this project.

License
-------

Clastic is licensed under the MIT license.
