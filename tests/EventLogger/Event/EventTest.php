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

namespace tests\EventLogger\Event;

use EventLogger\Event\Event;
use EventLogger\Logger\LoggableInterface;

/**
 * Test class for an Event
 *
 * Class EventTest
 * @package tests\EventLogger\Event
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventInterface
     */
    protected $event;

    /**
     * Setup this test class
     */
    public function setUp()
    {
        $this->event = new Event();
    }

    /**
     * Test that this event is an instance of LoggableInterface
     */
    public function testIsInstanceOfEventInterface()
    {
        $this->assertTrue($this->event instanceof LoggableInterface);
    }

    /**
     * Test that the event class properties are mutable
     */
    public function testPropertiesAreMutable()
    {
        $this->event->setType('event');
        $this->assertTrue('event' === $this->event->getType());
    }

    /**
     * Test that the event properties can be fetched as an array
     */
    public function testCanGetAsArray()
    {
        $this->event->setType('event');
        $this->assertTrue(is_array($this->event->toArray()));
    }
}