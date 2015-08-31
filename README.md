# Event logger library with support for multiple persistence strategies
[![Build Status](https://travis-ci.org/kabudu/event-logger.svg?branch=master)](https://travis-ci.org/kabudu/event-logger) [![Coverage Status](https://coveralls.io/repos/kabudu/event-logger/badge.svg)](https://coveralls.io/r/kabudu/event-logger)

Event logger is a PHP based event logger library that makes it easy to collect and query events in your web application based on user or system actions.

With event logger you can:

- collect any kind of statistical data such as number of clicks for a certain url, page views, conversions or any kind of user generated action for your web application, API or mobile application
- collect and store human readable event logs such as: **Bob smith updated his email address on 12th January, 2015 at 12:30AM**
- collect and store human readable user notifications such as: **Bob Smith sent you a message on 12th January, 2015 at 12:30AM**
- collect and store system events, either human readable or not
- and any other sort of event logging your imagination allows you to come up with

## Features

- Collect any kind of event data

    `@see EventLogger\Event\EventInterface`

- Query and analyse the collected data
- Multiple persistence strategies (currently ships with an SQLite and Null implementation)
- Extensible architecture
- Full test coverage with [phpunit](https://phpunit.de/)

## Requirements

- PHP 5.3.3+
- SQLite 3.0.7+ (required for the unit tests, you do not have to use the provided SQLite storage implementation)
- Optional but recommended: Composer

## Getting Started

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

## Log a Single Event

```
use EventLogger\Event\Event;
use EventLogger\Logger\Logger;
use EventLogger\Storage\SQLiteStorage;

// Initialise an SQLite database/table
$pdo = new \PDO('sqlite:my_event_log.sqlite');
$pdo->exec(sprintf("CREATE TABLE IF NOT EXISTS %s (
            id INTEGER PRIMARY KEY,
            type TEXT,
            sub_type TEXT DEFAULT NULL,
            target_type TEXT DEFAULT NULL,
            target_id INTEGER DEFAULT 0,
            message INTEGER DEFAULT NULL,
            data TEXT DEFAULT NULL,
            created TEXT DEFAULT '0000-00-00 00:00:00',
            action TEXT DEFAULT NULL,
            user TEXT DEFAULT NULL
        )",SQLiteStorage::TABLE_NAME));

// Create the storage strategy
$storage = new SQLiteStorage($pdo);

// Create the logger
$logger = new Logger($storage);

// Create an event
$event = new Event();
$event->setType('event');
$event->setSubType('pageview');
$event->setMessage('user [foo] viewed a page of interest to you');
$event->setData(array('[foo]' => 'bar'));
$event->setUser(2);

// Log the event
$logger->log($event);
```

## Log Multiple Events

```
use EventLogger\Event\Event;
use EventLogger\Logger\Logger;
use EventLogger\Storage\SQLiteStorage;
use EventLogger\Event\Collection\EventCollection;

// Initialise an SQLite database/table
$pdo = new \PDO('sqlite:my_event_log.sqlite');
$pdo->exec(sprintf("CREATE TABLE IF NOT EXISTS %s (
            id INTEGER PRIMARY KEY,
            type TEXT,
            sub_type TEXT DEFAULT NULL,
            target_type TEXT DEFAULT NULL,
            target_id INTEGER DEFAULT 0,
            message INTEGER DEFAULT NULL,
            data TEXT DEFAULT NULL,
            created TEXT DEFAULT '0000-00-00 00:00:00',
            action TEXT DEFAULT NULL,
            user TEXT DEFAULT NULL
        )",SQLiteStorage::TABLE_NAME));

// Create the storage strategy
$storage = new SQLiteStorage($pdo);

// Create the logger
$logger = new Logger($storage);

// Create an event
$event1 = new Event();
$event->setType('event');
$event->setSubType('pageview');
$event->setData(array('[foo]' => 'bar'));
$event->setUser(2);

// Create another event
$event2 = new Event();
$event->setType('event');
$event->setSubType('system');
$event->setMessage('A nominal value of [nominal] has been detected for the pressure release valve');
$event->setData(array('[nominal]' => '120'));

// create an event collection and add your events
$collection = new EventCollection();
$collection->addEvent($event1);
$collection->addEvent($event2);

// Log the events
$logger->log($collection);
```

## Log an Event to Multiple Persistence Back-ends

**Note:** In a real world application you might have implemented your own persistence strategies, e.g. MongoDB, Elasticsearch, Google Cloud Datastore etc.

```
use EventLogger\Event\Event;
use EventLogger\Logger\Logger;
use EventLogger\Storage\SQLiteStorage;
use EventLogger\Storage\NullStorage;
use EventLogger\Logger\Collection\LoggerCollection;

// Initialise an SQLite database/table
$pdo = new \PDO('sqlite:my_event_log.sqlite');
$pdo->exec(sprintf("CREATE TABLE IF NOT EXISTS %s (
            id INTEGER PRIMARY KEY,
            type TEXT,
            sub_type TEXT DEFAULT NULL,
            target_type TEXT DEFAULT NULL,
            target_id INTEGER DEFAULT 0,
            message INTEGER DEFAULT NULL,
            data TEXT DEFAULT NULL,
            created TEXT DEFAULT '0000-00-00 00:00:00',
            action TEXT DEFAULT NULL,
            user TEXT DEFAULT NULL
        )",SQLiteStorage::TABLE_NAME));

// Create a storage strategy
$sqliteStorage = new SQLiteStorage($pdo);

// Create another storage strategy
$nullStorage = new NullStorage();

// Create a logger
$logger1 = new Logger($sqliteStorage);

// Create another logger
$logger2 = new Logger($nullStorage);

// Create a logger collection and add your loggers
$collection = new LoggerCollection();
$collection->addLogger($logger1);
$collection->addLogger($logger2);


// Create an event
$event = new Event();
$event->setType('event');
$event->setSubType('pageview');
$event->setMessage('user [foo] viewed a page of interest to you');
$event->setData(array('[foo]' => 'bar'));
$event->setUser(2);

// Log the event
$collection->log($event);
```
