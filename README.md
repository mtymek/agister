AGIster
=======

Introduction
------------

AGIster is a simple TODO management tool, presenting tasks in as "AGIs" - achievements, goals and issues.
It was written as a playground to some interesting technologies like ZF-Rest, AngularJS and few others.

Installation
------------

Agister requires [Bower](http://bower.io/) and INTL extension.

1. Clone Agister repository:

        git clone git@github.com:mtymek/agister.git agister
        cd agister

2. Install PHP dependencies via composer:

        ./composer installI

3. Install JS dependencies using bower:

        bower install

5. Copy `config/autoload/local.php.dist` to `config/autoload/local.php` file, edit it and update database
 user and password.

4. Create new database:

        mysql -u root -p PASSWORD -e 'create database agister'

5. Create initial schema:

        ./vendor/bin/doctrine-module orm:schema-tool:create
