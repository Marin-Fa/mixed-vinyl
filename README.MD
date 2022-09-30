Mixed Vinyl Application
This is a data repository that will be used in our Symfony 6 Tutorials

Requirements
PHP 8 or higher;
PDO-SQLite PHP extension enabled;
and the usual Symfony application requirements.
Installation
Install the Mixed Vinyl binary on your computer and run this command:

$ git clone https://github.com/Marin-Fa/mixed-vinyl.git

Usage
No database needed, it's only in AJAX for the moment:

$ composer install

Launch the webserver:

$ npm run watch
$ symfony serve

If you don't have the Symfony binary installed, you can run built-in PHP web server:

$ php -S localhost:8000 -t public/

Or configure a web server like Nginx or Apache to run the application.