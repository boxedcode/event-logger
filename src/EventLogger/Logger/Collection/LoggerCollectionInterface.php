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

namespace EventLogger\Logger\Collection;

use EventLogger\Logger\LoggableInterface;
use EventLogger\Logger\LoggerInterface;

/**
 * Logger collection interface for a collection of loggers
 *
 * Interface LoggerCollectionInterface
 * @package EventLogger\Logger\Collection
 */
interface LoggerCollectionInterface extends \ArrayAccess, \IteratorAggregate
{
    /**
     * Add a logger to this collection
     *
     * @param LoggerInterface $logger
     * @return mixed
     */
    public function addLogger(LoggerInterface $logger);

    /**
     * Get the loggers in this collection
     *
     * @return array
     */
    public function getLoggers();

    /**
     * Set loggers for this collection
     *
     * @param array $loggers
     * @return mixed
     */
    public function setLoggers(array $loggers);

    /**
     * Log an event
     *
     * @param LoggableInterface $loggable
     * @return mixed
     */
    public function log(LoggableInterface $loggable);
}