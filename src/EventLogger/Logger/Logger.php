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

namespace EventLogger\Logger;

use EventLogger\Event\Collection\EventCollectionInterface;
use EventLogger\Event\EventInterface;
use EventLogger\Storage\StorageInterface;

/**
 * Default implementation of a logger class
 *
 * Class Logger
 * @package EventLogger\Logger
 */
class Logger implements LoggerInterface
{
    /**
     * Storage strategy
     *
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Constructor
     *
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Log an event
     *
     * @param EventInterface $event
     * @return mixed
     */
    public function log(EventInterface $event)
    {
        $this->storage->save($event->toArray());
    }

    /**
     * Log a collection of events
     *
     * @param EventCollectionInterface $eventCollection
     * @return mixed
     */
    public function logMultiple(EventCollectionInterface $eventCollection)
    {
        foreach ($eventCollection as $event) {
            $this->storage->save($event->toArray());
        }
    }

    /**
     * Set a storage strategy for this logger
     *
     * @param StorageInterface $storage
     * @return LoggerInterface
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get the storage strategy injected into this logger
     *
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

}