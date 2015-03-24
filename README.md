# Event logger library with support for multiple persistence strategies (back-end support)
Event logger is a PHP based event logger library that makes it easy to collect and query events in your web application based on user or system actions.

With event logger you can:

- collect any kind of statistical data such as number of clicks for a certain url, page views, conversions or any kind of user generated action for your web application, API or mobile application
- collect and store human readable event logs such as: "Bob smith updated his email address on 12th January, 2015 at 12:30AM"
- collect and store human readable user notifications such as: "Bob Smith sent you a message on 12th January, 2015 at 12:30AM"
- collect and store system events, either human readable or not
- and any other sort of event logging your imagination allows you to come up with

# Features

- Collect any kind of event data

    `@see EventLogger\Event\EventInterface`

- Query and analyse the collected data
- Multiple persistence strategies (currently ships with an SQLite and Null implementation)
- Extensible architecture
- Full test coverage with [phpunit](https://phpunit.de/)

# Requirements

- PHP 5.3.3+
- SQLite 3.0.7+ (required for the unit tests, you do not have to use the provided SQLite storage implementation)
- Optional but recommended: Composer

# Getting Started

The simplest way to work with event-logger is when it is installed as a Composer package in your application. Composer is not required, but it simplifies the usage of this library.

To find out more about Composer, please visit [https://getcomposer.org/](https://getcomposer.org/)

a) Add event-logger to your applications composer.json file

```
// ...
"require": {
     "kabudu/event-logger": "1.x"  // The most recent tagged version
 },
// ...
```

Run `composer install`

b) Add the Composer autoload to your projects bootstrap file if you have not done so already. (example)

`require 'vendor/autoload.php';`

c) If you are not using Composer, simply download the package and copy the "src" folder into your project ensuring that your application can autoload the libraries classes