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

namespace EventLogger\Event;

/**
 * Event interface for an event
 *
 * Interface EventInterface
 * @package EventLogger\Event
 */
interface EventInterface
{
    /**
     * Get the type
     *
     * @return mixed
     */
    public function getType();

    /**
     * Set the type
     *
     * @param mixed $type
     * @return mixed
     */
    public function setType($type);

    /**
     * Get the sub type
     *
     * @return mixed
     */
    public function getSubType();

    /**
     * Set the sub type
     *
     * @param mixed $subType
     * @return mixed
     */
    public function setSubType($subType);

    /**
     * Get the target type
     *
     * @return mixed
     */
    public function getTargetType();

    /**
     * Set the target type
     *
     * @param mixed $targetType
     * @return mixed
     */
    public function setTargetType($targetType);

    /**
     * Get the target Id
     *
     * @return mixed
     */
    public function getTargetId();

    /**
     * Set the target Id
     *
     * @param mixed $targetId
     * @return mixed
     */
    public function setTargetId($targetId);

    /**
     * Get the message
     *
     * @return mixed
     */
    public function getMessage();

    /**
     * Set the message
     *
     * @param mixed $message
     * @return mixed
     */
    public function setMessage($message);

    /**
     * Get the data
     *
     * @return mixed
     */
    public function getData();

    /**
     * Set the data
     *
     * @param mixed $data
     * @return mixed
     */
    public function setData($data);

    /**
     * Get the created date/time for this event
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Set the created date/time for this event
     *
     * @param \DateTime $created
     * @return mixed
     */
    public function setCreated(\DateTime $created);

    /**
     * Get the action
     *
     * @return mixed
     */
    public function getAction();

    /**
     * Set the action
     *
     * @param mixed $action
     * @return mixed
     */
    public function setAction($action);

    /**
     * Get the user
     *
     * @return mixed
     */
    public function getUser();

    /**
     * Set the user
     *
     * @param mixed $user
     * @return mixed
     */
    public function setUser($user);
}