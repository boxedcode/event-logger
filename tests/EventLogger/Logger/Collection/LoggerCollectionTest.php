<?php
/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace tests\EventLogger\Logger\Collection;

use EventLogger\Event\Event;
use EventLogger\Logger\Collection\LoggerCollection;
use EventLogger\Logger\Collection\LoggerCollectionInterface;
use EventLogger\Logger\Logger;
use EventLogger\Logger\LoggerInterface;
use EventLogger\Storage\NullStorage;
use EventLogger\Storage\SQLiteStorage;

/**
 * Test class for the LoggerCollection
 *
 * Class LoggerCollectionTest
 * @package tests\EventLogger\Logger\Collection
 */
class LoggerCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerCollectionInterface
     */
    protected $collection;

    /**
     * @var LoggerInterface
     */
    protected $logger1;

    /**
     * @var LoggerInterface
     */
    protected $logger2;

    /**
     * Set up this test class
     */
    protected function setUp()
    {
        $this->collection = new LoggerCollection();

        $pdo = new \PDO('sqlite::memory:');
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

        $this->logger1 = new Logger(new SQLiteStorage($pdo));
        $this->logger2 = new Logger(new NullStorage());
    }

    /**
     * Test that the logger collection is an instance of LoggerCollectionInterface
     */
    public function testIsInstanceofLoggerCollectionInterface()
    {
        $this->assertTrue($this->collection instanceof LoggerCollectionInterface);
    }

    /**
     * Test that the logger collection can accept loggers
     */
    public function testCanContainLoggers()
    {
        $this->collection->addLogger($this->logger1);
        $this->collection->addLogger($this->logger2);

        $this->assertTrue(2 == count($this->collection->getLoggers()));
    }

    /**
     * Test that loggers can be removed from the collection
     */
    public function testCanRemoveLoggers()
    {
        $this->collection->addLogger($this->logger1);
        $this->collection->addLogger($this->logger2);

        unset($this->collection[0]);

        $this->assertTrue(1 == count($this->collection->getLoggers()));
    }

    /**
     * Test that the collection can log an event
     */
    public function testCollectionCanLogEvent()
    {
        $this->collection->addLogger($this->logger1);
        $this->collection->addLogger($this->logger2);

        $event = new Event();
        $event->setType('event');
        $event->setSubType('pageview');
        $event->setData(array('[foo]' => 'bar'));
        $event->setUser(2);

        $this->collection->log($event);

        $results = $this->collection[0]->getStorage()->fetch(array(
            'type'  =>  'event',
            'sub_type'  =>  'pageview',
        ));

        $this->assertTrue(1 == count($results));
        $this->assertTrue($results[0]['sub_type'] == 'pageview');

        $this->assertTrue(NULL === $this->collection[1]->getStorage()->fetch(array()));
    }
}