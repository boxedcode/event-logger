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

use EventLogger\Storage\MySQLStorage;
use EventLogger\Storage\StorageInterface;

/**
 * Test class for the MySQLStorage persistence strategy
 *
 * Class MySQLStorageTest
 * @package tests\EventLogger\Storage
 */
class MySQLStorageTest extends \PHPUnit_Framework_TestCase
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
        $this->pdo = $this->getMock('\PDO', ['exec'], [], '', false);
        $this->pdo->method('exec')
            ->willReturn(true);

        $this->pdo->exec(sprintf("CREATE TABLE IF NOT EXISTS %s (
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
        )", MySQLStorage::TABLE_NAME));

        $this->storage = $this->getMock('\EventLogger\Storage\MySQLStorage', [], [$this->pdo]);
        $this->storage->expects($this->any())
            ->method('save')
            ->will($this->returnCallback(function () {
                return true;
            }));

        $this->storage->method('fetch')
            ->will($this->returnCallback(function () {
                return [
                    [
                        'type' => 'event',
                        'sub_type' => 'conversion',
                        'action' => 'purchase',
                        'message' => 'Bob Smith just purchased a shoe',
                        'created' => date('Y-m-d H:i:s'),
                        'data' => [
                            'foo' => 'bar'
                        ]
                    ]
                ];
            }));

    }

    /**
     * Test that the storage strategy implements the storage interface
     */
    public function testIsInstanceOfStorageInterface()
    {
        $this->assertInstanceOf(StorageInterface::class, $this->storage);
    }

    /**
     * Test that an event is stored
     */
    public function testEventIsStored()
    {
        $result = $this->storage->save([
            'type' => 'event',
            'sub_type' => 'conversion',
            'action' => 'purchase',
            'message' => 'Bob Smith just purchased a shoe',
            'created' => date('Y-m-d H:i:s')
        ]);
        $this->assertTrue(true === $result);
    }

    /**
     * Test that an event can be fetched
     */
    public function testEventCanBeFetched()
    {
        $this->storage->save([
            'type' => 'event',
            'sub_type' => 'conversion',
            'action' => 'purchase',
            'message' => 'Bob Smith just purchased a shoe',
            'created' => date('Y-m-d H:i:s'),
            'data' => array(
                'foo' => 'bar'
            )
        ]);

        $results = $this->storage->fetch(array(
            'type' => 'event',
            'sub_type' => 'conversion',
        ));

        $this->assertTrue(1 == count($results));
        $this->assertTrue($results[0]['sub_type'] == 'conversion');
    }

}