<?php

namespace tests\EventLogger\Storage;

use EventLogger\Storage\SQLiteStorage;
use EventLogger\Storage\StorageInterface;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;

class SQLiteStorageTest extends \PHPUnit_Extensions_Database_TestCase
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
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
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

        return $this->createDefaultDBConnection($pdo, ':memory:');
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/event-seed.xml');
    }

    /**
     * Setup method
     */
    protected function setUp()
    {
        parent::setUp();

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