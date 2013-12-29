AGIster
=======

Introduction
------------

AGIster is a simple TODO management tool, presenting tasks in as "AGIs" - achievements, goals and issues.

Installation
------------

Agister requires [Bower](http://bower.io/) and INTL extension.

1. Clone Agister repository:

        git clone git@github.com:mtymek/agister.git agister
        cd agister

2. Install PHP dependencies via composer:

        ./composer install

3. Install JS dependencies using bower:

        bower install

5. Copy `config/autoload/local.php.dist` to `config/autoload/local.php` file, edit it and update database
 user and password.

4. Create new database:

        mysql -u root -p PASSWORD -e 'create database agister'

5. Create initial schema:

        ./vendor/bin/doctrine-module orm:schema-tool:create


Christmas Challenge
-------------------

AGIster is supposed to be a short project, written to improve my coding skills and possibly learn something new.

Technologies:

* Zend Framework 2 as PHP framework
* Doctrine 2 as database backend
* ZF-REST module for API
* Twitter Bootstrap as CSS framework
* AngularJS as frontend framework

Goals (new elements may be added during coding):

- [X] create simple skeleton app based on ZF2 and Doctrine
- [ ] create backend module that defines entities used by app and services for accessing them
    - [X] define internal data structures: tasks, timeline, etc. No need to take care of users for now.
    - [ ] write unit tests
- [ ] create control module that exposes services and entities and operates on data in JSON format
    - [X] use ZF-Rest module for API
    - [ ] write unit tests
- [ ] create frontend module (with help of AssetManager module)
    - [X] use Bower for managing front-end packages
    - [X] use Angular.js as frontend engine
    - [X] allow adding new tasks
    - [ ] allow marking tasks as "completed"
    - [ ] create simple timeline showing current tasks, something reassembling Liquid Planer's timeline
- [ ] try not to drink too much coke during development