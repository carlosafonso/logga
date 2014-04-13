logga
=====

Logga is a logging library for PHP designed for simplicity and ease of use. Starting from v1.0.0, Logga features support for multiple logging streams and message formatters, providing developers with great flexibility.

Current version features a file stream and a default formatter. Future releases of Logga will have a Database stream out of the box, as well as a plugin system to allow developers to write custom streams and formatters so that pretty much every logging need is covered.

##Installation
###Composer
Since version 2.0.0 Logga can be installed using [Composer](https://getcomposer.org/). Add the following dependency to your `composer.json`:

```json
{
  "require": {
    "carlosafonso/logga": "2.*",
  }
}
```

Then run:

```bash
$ composer update
```

Don't forget to include Composer's autoload file if you haven't done so already:

```php
require 'vendor/autoload.php':
```

###Manual installation
Logga can also be installed by [downloading the latest version](https://github.com/carlosafonso/logga/archive/master.zip) and unzipping everything into your project folder, or by cloning the repository:

```bash
$ git clone https://github.com/carlosafonso/logga.git
```

Remember to include the main library file into your project:
```php
require 'logga.php';
```
##Quick start
Set up a quick logger with the following code:

```php
$l = new \CarlosAfonso\Logga\Logga();
$l->info('Hello world!');
```

If you run this code, a file named something like ``default_log.log`` will appear in your project's root path. A quick look into it reveals the following:

```text
[2014-02-15 17:42:14][INFO   ]: Hello world!
```

And that's pretty much it! You have set up your logging system with just a couple of lines. From now on you can trace everything you need using any of the five logging functions provided by Logga (``debug()``, ``info()``, ``warning()``, ``error()`` and ``fatal()``).

##Usage
This section is currently under development and will be available soon. In the meanwhile feel free to check the code out to see the inner workings of Logga.
