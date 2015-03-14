Development
===========

Installation
------------

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

Update
------

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
