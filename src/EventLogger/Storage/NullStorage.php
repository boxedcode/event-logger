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

namespace EventLogger\Storage;

/**
 * Null storage implementation
 *
 * Class NullStorage
 * @package EventLogger\Storage
 */
class NullStorage implements StorageInterface
{
    /**
     * Save an event
     *
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        // Do nothing
    }

    /**
     * Fetch one or more events
     *
     * @param array $criteria
     * @param null $callback
     * @return mixed
     */
    public function fetch(array $criteria, $callback = null)
    {
        return null;
    }

}