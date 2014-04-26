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

If you run this code, the following line will be printed on screen:

```text
[2014-02-15 17:42:14][INFO   ]: Hello world!
```

Furthermore, a file named something like ``default_log.log`` will appear in the folder you're running your script from. A quick look into it reveals the same content shown above.

And that's pretty much it! You have set up your logging system with just a couple of lines. From now on you can trace everything you need using any of the eight logging functions provided by Logga (``debug()``, ``info()``, ``notice()``, ``warning()``, ``error()``, ``critical()``, ``alert()`` and ``emergency()``).

##Usage
The above is simple enough for the average developer but you might want to customize Logga a bit in order to fulfill your needs. This section will show you how.

###Understanding streams
In Logga, as in other logging libraries, a stream is an abstraction of a place where log messages are stored. You can use as many streams as you need, so that logging a message just once produces the same output in different places (i.e., a plain text file and a database table).

Additionally, you can configure each stream: for example, you might want all messages to be logged to the plain text file but only WARNING messages or above into the database.

As of version 2.0.0, Logga comes with 2 streams: ``FileStream`` and ``StandardOutputStream`` (with several others currently in the works, such as ``DatabaseStream``. ``HttpStream`` and ``MailStream``).

###Default streams
If you don't specifically provide any stream to Logga's constructor, the library will use both a ``FileStream`` and a ``StandardOutputStream`` by default (the first one logging to a file named ``default_log.log``).

###Creating a custom stream
You can create a stream by instantiating any class which extends from ``LogStream``, optionally passing an array with the desired options:

```php
$s = new FileStream(array('file' => 'my_custom_log_file', 'date' => TRUE));
$l = new Logga($s);
$l->info('Hi, custom file!');
```

The above will produce a file called ``my_custom_log_file_<datetime>.log``, where ``datetime`` is the current date and time.

You can use more than one stream. Just call Logga's constructor with an array of streams:

```php
$s1 = new FileStream(array('file' => 'my_first_custom_log_file', 'date' => TRUE));
$s2 = new FileStream(array('file' => 'my_second_custom_log_file', 'date' => TRUE));
$l = new Logga(array($s1, $s2));
$l->info('Hi, custom file!');
```

##Streams
###Specifying a log level
<TBC>

###Enabling and disabling streams
<TBC>

###Available stream classes
<TBC>

##Formatters
<TBC>
