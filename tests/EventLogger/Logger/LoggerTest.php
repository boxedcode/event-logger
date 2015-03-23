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

namespace tests\EventLogger\Logger;

use EventLogger\Event\Event;
use EventLogger\Logger\Logger;
use EventLogger\Logger\LoggerInterface;
use EventLogger\Storage\NullStorage;
use EventLogger\Storage\SQLiteStorage;
use EventLogger\Storage\StorageInterface;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Set up for this test class
     */
    protected function setUp()
    {
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

        $storage = new SQLiteStorage($pdo);
        $this->logger = new Logger($storage);
    }

    /**
     * Test that the logger implements the LoggerInterface
     */
    public function testIsInstanceOfLoggerInterface()
    {
        $this->assertTrue($this->logger instanceof LoggerInterface);
    }

    /**
     * Test that the logger has a persistence implementation
     */
    public function testLoggerHasStorageImplementation()
    {
        $this->assertTrue($this->logger->getStorage() instanceof StorageInterface);
    }

    /**
     * Test that the storage strategy for this logger is mutable
     */
    public function testLoggerStorageIsMutable()
    {
        $this->logger->setStorage(new NullStorage());
        $this->assertTrue($this->logger->getStorage() instanceof NullStorage);
    }

    /**
     * Test that the logger can log an event
     */
    public function testLoggerCanLogEvent()
    {
        $event = new Event();
        $event->setType('event');
        $event->setSubType('pageview');
        $event->setData(array('[foo]' => 'bar'));
        $event->setUser(2);

        $this->logger->log($event);

        $results = $this->logger->getStorage()->fetch(array(
            'type'  =>  'event',
            'sub_type'  =>  'pageview',
        ));

        $this->assertTrue(1 == count($results));
        $this->assertTrue($results[0]['sub_type'] == 'pageview');
    }
}