Mixed Vinyl Application
========================

The "Mixed Vinyl Application" is a data repository that will be used in our Symfony 6 Tutorials.

This project is only in english.

Requirements
------------

* PHP 8 or higher;
* PDO-SQLite PHP extension enabled;
* and the [usual Symfony application requirements][2].

Installation
------------

Install the `Mixed Vinyl` binary on your computer and run
this command:

```bash
$ git clone https://github.com/Marin-Fa/mixed-vinyl.git
```

Usage
-----

Usage No database needed, it's only in AJAX for the moment:

Generate migrations:

```bash
$ composer install
```

```bash
$ npm install
```

Launch the webserver:

```bash
$ symfony server:start -d
```

Launch Webpack Ecore

```bash
$ npm run watch
```

If you don't have the Symfony binary installed, you can run built-in PHP web server:

```bash
$ php -S localhost:8000 -t public/
```

Or [configure a web server][3] like Nginx or
Apache to run the application.


[1]: https://symfony.com/doc/current/best_practices.html
[2]: https://symfony.com/doc/current/reference/requirements.html
[3]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[4]: https://symfony.com/download