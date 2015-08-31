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

namespace EventLogger\Event\Collection;

use EventLogger\Event\EventInterface;
use EventLogger\Logger\LoggableInterface;

/**
 * Event collection interface for a collection of events
 *
 * Interface EventCollectionInterface
 * @package EventLogger\Event\Collection
 */
interface EventCollectionInterface extends \ArrayAccess, \IteratorAggregate, LoggableInterface
{
    /**
     * Add an event to this collection
     *
     * @param EventInterface $event
     * @return mixed
     */
    public function addEvent(EventInterface $event);

    /**
     * Get the events associated with this collection
     *
     * @return mixed
     */
    public function getEvents();

    /**
     * Set events for this collection
     *
     * @param array $events
     * @return mixed
     */
    public function setEvents(array $events);
}