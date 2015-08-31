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

namespace tests\EventLogger\Event\Collection;

use EventLogger\Event\Collection\EventCollection;
use EventLogger\Event\Collection\EventCollectionInterface;
use EventLogger\Event\Event;
use EventLogger\Event\EventInterface;
use EventLogger\Logger\LoggableInterface;

/**
 * Test class for an EventCollection
 *
 * Class EventCollectionTest
 * @package tests\EventLogger\Event\Collection
 */
class EventCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventInterface
     */
    protected $event1;

    /**
     * @var EventInterface
     */
    protected $event2;

    /**
     * @var EventCollectionInterface
     */
    protected $collection;

    /**
     * Set up this test class
     */
    protected function setUp()
    {
        $this->event1 = new Event();
        $this->event1->setType('event');
        $this->event1->setSubType('pageview');
        $this->event1->setData(array('[foo]' => 'bar'));
        $this->event1->setUser(2);

        $this->event2 = new Event();
        $this->event2->setType('event');
        $this->event2->setSubType('conversion');
        $this->event2->setData(array('[pah]' => 'tah'));
        $this->event2->setUser(6);

        $this->collection = new EventCollection();
    }

    /**
     * Test that the collection is an instance of EventCollectionInterface
     */
    public function testIsInstanceOfEventCollectionInterface()
    {
        $this->assertTrue($this->collection instanceof LoggableInterface);
    }

    /**
     * Test that the collection can accept events
     */
    public function testCanContainEvents()
    {
        $this->collection->addEvent($this->event1);
        $this->collection->addEvent($this->event2);

        $this->assertTrue(2 === count($this->collection->getEvents()));
    }

    /**
     * Test that the collection can remove events
     */
    public function testCanRemoveEvents()
    {
        $this->collection->addEvent($this->event1);
        $this->collection->addEvent($this->event2);

        unset($this->collection[0]);

        $this->assertTrue(1 === count($this->collection->getEvents()));
    }
}