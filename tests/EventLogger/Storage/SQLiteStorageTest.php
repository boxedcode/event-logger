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

namespace tests\EventLogger\Storage;

use EventLogger\Storage\SQLiteStorage;
use EventLogger\Storage\StorageInterface;

/**
 * Test class for the SQLiteStorage persistence strategy
 *
 * Class SQLiteStorageTest
 * @package tests\EventLogger\Storage
 */
class SQLiteStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Setup method
     */
    protected function setUp()
    {
        parent::setUp();

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

        $this->pdo = $pdo;

        $this->storage = new SQLiteStorage($this->pdo);
    }

    /**
     * Test that the storage strategy implements the storage interface
     */
    public function testIsInstanceOfStorageInterface()
    {
        $this->assertTrue($this->storage instanceof StorageInterface);
    }

    /**
     * Test that an event is stored
     */
    public function testEventIsStored()
    {
        $result = $this->storage->save(array(
            'type'  =>  'event',
            'sub_type'  =>  'conversion',
            'action'    =>  'purchase',
            'message'   =>  'Bob Smith just purchased a shoe',
            'created'   =>  date('Y-m-d H:i:s')
        ));
        $this->assertTrue(TRUE === $result);
    }

    /**
     * Test that an event can be fetched
     */
    public function testEventCanBeFetched()
    {
        $this->storage->save(array(
            'type'  =>  'event',
            'sub_type'  =>  'conversion',
            'action'    =>  'purchase',
            'message'   =>  'Bob Smith just purchased a shoe',
            'created'   =>  date('Y-m-d H:i:s'),
            'data'      =>  array(
                'foo'   =>  'bar'
            )
        ));

        $results = $this->storage->fetch(array(
            'type'  =>  'event',
            'sub_type'  =>  'conversion',
        ));

        $this->assertTrue(1 == count($results));
        $this->assertTrue($results[0]['sub_type'] == 'conversion');
    }

}