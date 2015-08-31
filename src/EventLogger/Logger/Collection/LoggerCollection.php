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

use EventLogger\Event\Collection\EventCollectionInterface;
use EventLogger\Logger\LoggableInterface;
use EventLogger\Logger\LoggerInterface;
use Traversable;

class LoggerCollection implements LoggerCollectionInterface
{
    /**
     * @var LoggerInterface[]
     */
    protected $loggers = array();

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->loggers);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        if (isset($this->loggers[$offset])) {
            return true;
        }

        return false;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->loggers[$offset];
        }

        return null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->loggers[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->loggers[$offset]);
        }
    }

    /**
     * Log an event
     *
     * @param LoggableInterface $loggable
     * @return mixed
     */
    public function log(LoggableInterface $loggable)
    {
        if ($loggable instanceof EventCollectionInterface) {
            foreach ($this as $logger) {
                foreach ($loggable as $event) {
                    $logger->log($event);
                }
            }
        } else {
            foreach ($this as $logger) {
                $logger->log($loggable);
            }
        }
    }

    /**
     * Add a logger to this collection
     *
     * @param LoggerInterface $logger
     * @return mixed
     */
    public function addLogger(LoggerInterface $logger)
    {
        $this->loggers[] = $logger;
    }

    /**
     * Get the loggers in this collection
     *
     * @return array
     */
    public function getLoggers()
    {
        return $this->loggers;
    }

    /**
     * Set loggers for this collection
     *
     * @param array $loggers
     * @return mixed
     */
    public function setLoggers(array $loggers)
    {
        $this->loggers = $loggers;
    }

}