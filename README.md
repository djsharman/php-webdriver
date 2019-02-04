# Asynchronous php-webdriver using coroutines– Selenium WebDriver bindings for asynchronous PHP

## Description 
This is a fork of the facebook php-webdriver to allow asynchronous selenium operations from a single threaded PHP test system.

# How it works
The asynchronous functionality is provided by using coroutines. I use the excellent reactphp and icicle.io in this fork. 
 
## Example use cases
Using this system you can make multiple execution tasks simultaneously occur. For example you can create multiple user browsers that access your system under test, and make them undertake actions asynchronously. So one user could be uploading a file, another could be logging in, another could be an admin creating users, or another could be a ZMQ listener waiting for a signal to kick off other phases of your test.

## How to get started
To make things simple I have provided an example of how to use the system along with a Docker setup to get the required selenium instance up and running quickly.

To get started clone the repo then follow the steps below.

### Run the selenium 
If you already have a selenium instance running locally on port 4444 you can skip this step.

Open a command prompt and run the following

    cd examples/docker/
    ./runSelenium.sh

### Run an example

    cd examples/src/
    php LoadBrowsersExample.php

### Seeing the results with VNC

The selenium docker instance provided has a VNC server embedded into it. You can connect to it on port 5901

    vncviewer 127.0.0.1:5901

The password is "secret".

### What you should see
You should see a set of 10 browsers loading the www.google.co.uk homepage.

If you rerun the example you should see all the browsers getting closed then being recreated.

## Any problems / Questions?
Please raise a bug report in github and I will look into it.

Alternatively write to me at darren.sharman (at) nemtek.co.uk

## PHP versions tested
I have tested this with PHP7.0 and php7.2
If you don't have a compatible php version you can try the additional docker instance I provided that should give you a php7.0 test shell.

        cd examples/docker/
        ./runDocker.sh

Then start a test shell

    cd examples/docker/
    ./testShell.sh

You should be able to run the test script from there by following the instructions above.

------------------------------------------
# The Original description from the facebook php-webdriver follows below.

[![Latest Stable Version](https://img.shields.io/packagist/v/facebook/webdriver.svg?style=flat-square)](https://packagist.org/packages/facebook/webdriver)
[![Travis Build](https://img.shields.io/travis/facebook/php-webdriver/community.svg?style=flat-square)](https://travis-ci.org/facebook/php-webdriver)
[![Sauce Test Status](https://saucelabs.com/buildstatus/php-webdriver)](https://saucelabs.com/u/php-webdriver)
[![Total Downloads](https://img.shields.io/packagist/dt/facebook/webdriver.svg?style=flat-square)](https://packagist.org/packages/facebook/webdriver)
[![License](https://img.shields.io/packagist/l/facebook/webdriver.svg?style=flat-square)](https://packagist.org/packages/facebook/webdriver)

## Description
Php-webdriver library is PHP language binding for Selenium WebDriver, which allows you to control web browsers from PHP.

This library is compatible with Selenium server version 2.x and 3.x.
It implements the [JsonWireProtocol](https://github.com/SeleniumHQ/selenium/wiki/JsonWireProtocol), which is currently supported
by the Selenium server and will also implement the [W3C WebDriver](https://w3c.github.io/webdriver/webdriver-spec.html) specification in the future.

The concepts of this library are very similar to the "official" Java, .NET, Python and Ruby bindings from the
[Selenium project](https://github.com/SeleniumHQ/selenium/).

**This is new version of PHP client, rewritten from scratch starting 2013.**
Using the old version? Check out [Adam Goucher's fork](https://github.com/Element-34/php-webdriver) of it.

Looking for API documentation of php-webdriver? See [https://facebook.github.io/php-webdriver/](https://facebook.github.io/php-webdriver/latest/)

Any complaint, question, idea? You can post it on the user group https://www.facebook.com/groups/phpwebdriver/.

## Installation

Installation is possible using [Composer](https://getcomposer.org/).

If you don't already use Composer, you can download the `composer.phar` binary:

    curl -sS https://getcomposer.org/installer | php

Then install the library:

    php composer.phar require facebook/webdriver

## Getting started

All you need as the server for this client is the `selenium-server-standalone-#.jar` file provided here: http://selenium-release.storage.googleapis.com/index.html

Download and run that file, replacing # with the current server version. Keep in mind you must have Java 8+ installed to start this command.

    java -jar selenium-server-standalone-#.jar

(Please see note below when using Firefox.)

Then when you create a session, be sure to pass the url to where your server is running.

```php
// This would be the url of the host running the server-standalone.jar
$host = 'http://localhost:4444/wd/hub'; // this is the default
```

##### Launch Chrome

Make sure to have latest Chrome and [Chromedriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) installed.

```php
$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
```

##### Launch Firefox

Make sure to have latest Firefox and [Geckodriver](https://github.com/mozilla/geckodriver/releases) installed.

Because Firefox (and Geckodriver) only supports new W3C WebDriver protocol (which is yet to be implemented by php-wedbriver - see [issue #469](https://github.com/facebook/php-webdriver/issues/469)),
the protocols must be translated by Selenium server - this feature is *partially* available in Selenium server version 3.5.0-3.8.1 and you can enable it like this:

    java -jar selenium-server-standalone-3.8.1.jar -enablePassThrough false

Now you can start Firefox from your code:

```php
$driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());
```

##### You can also customize the desired capabilities

```php
$desired_capabilities = DesiredCapabilities::firefox();
$desired_capabilities->setCapability('acceptSslCerts', false);
$driver = RemoteWebDriver::create($host, $desired_capabilities);
```

* See https://github.com/SeleniumHQ/selenium/wiki/DesiredCapabilities for more details.

* Above snippets are not intended to be a working example by simply copy pasting. See [example.php](example.php) for working example.

## Changelog
For latest changes see [CHANGELOG.md](CHANGELOG.md) file.

## More information

Some how-tos are provided right here in [our GitHub wiki](https://github.com/facebook/php-webdriver/wiki).

You may also want to check out the Selenium [docs](http://docs.seleniumhq.org/docs/) and [wiki](https://github.com/SeleniumHQ/selenium/wiki).

## Testing framework integration

To take advantage of automatized testing you will most probably want to integrate php-webdriver to your testing framework.
There are some project already providing this:

- [Steward](https://github.com/lmc-eu/steward) integrates php-webdriver directly to [PHPUnit](https://phpunit.de/), also providers parallelization.
- [Codeception](http://codeception.com) testing framework provides BDD-layer on top of php-webdriver in its [WebDriver module](http://codeception.com/docs/modules/WebDriver).
- You can also check out this [blogpost](http://codeception.com/11-12-2013/working-with-phpunit-and-selenium-webdriver.html) + [demo project](https://github.com/DavertMik/php-webdriver-demo), describing simple [PHPUnit](https://phpunit.de/) integration.

## Support

We have a great community willing to try and help you!

- **Via our Facebook Group** - If you have questions or are an active contributor consider joining our [facebook group](https://www.facebook.com/groups/phpwebdriver/) and contributing to the communal discussion and support.
- **Via StackOverflow** - You can also [ask a question](https://stackoverflow.com/questions/ask?tags=php+selenium-webdriver) or find many already answered question on StackOverflow.
- **Via GitHub** - Another option if you have a question (or bug report) is to [submit it here](https://github.com/facebook/php-webdriver/issues/new) as an new issue.

## Contributing

We love to have your help to make php-webdriver better. See [CONTRIBUTING.md](CONTRIBUTING.md) for more information
about contributing and developing php-webdriver.
