AGIster
=======

Introduction
------------

AGIster is a simple TODO management tool, presenting tasks in as "AGIs" - achievements, goals and issues.

Christmas Challenge
-------------------

AGIster is supposed to be a short project, written to improve my coding skills and possibly learn something new.

Technologies:

* Zend Framework 2 as PHP framework
* Doctrine 2 as database backend
* Twitter Bootstrap as CSS framework
* some JS template library

Goals (new elements may be added during coding):

- [X] create simple skeleton app based on ZF2 and Doctrine
- [ ] create backend module that defines entities used by app and services for accessing them
    - [ ] define internal data structures: tasks, tags, etc. No need to take care of users for now.
    - [ ] write unit tests
- [ ] create control module that exposes services and entities and operates on data in JSON format
    - [X] use ZF-Rest module for API
    - [ ] write unit tests
- [ ] create frontend module (with help of AssetManager module)
    - [X] use Bower for managing front-end packages
    - [ ] allow adding new tasks
    - [ ] allow marking tasks as "completed"
    - [ ] create simple timeline showing current tasks, something reassembling Liquid Planer's timeline
- [ ] try not to drink too much coke during development