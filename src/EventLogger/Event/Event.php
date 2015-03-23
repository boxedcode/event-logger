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
 * Default event implementation
 *
 * Class Event
 * @package EventLogger\Event
 */
class Event implements EventInterface
{
    /**
     * @var mixed
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $subType;

    /**
     * @var mixed
     */
    protected $targetType;

    /**
     * @var mixed
     */
    protected $targetId;

    /**
     * @var mixed
     */
    protected $message;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var mixed
     */
    protected $action;

    /**
     * @var mixed
     */
    protected $user;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * @param mixed $subType
     * @return $this
     */
    public function setSubType($subType)
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
     * @param mixed $targetType
     * @return $this
     */
    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * @param mixed $targetId
     * @return $this
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get this event as an array
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'type'          =>  $this->getType(),
            'sub_type'      =>  $this->getSubType(),
            'target_type'   =>  $this->getTargetType(),
            'target_id'     =>  $this->getTargetId(),
            'message'       =>  $this->getMessage(),
            'data'          =>  $this->getData(),
            'created'       =>  isset($this->created) ? $this->getCreated()->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
            'action'        =>  $this->getUser(),
            'user'          =>  $this->getUser()
        );
    }


}