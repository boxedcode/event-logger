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
 * A simple SQLite persistence strategy for storing and querying events
 *
 * Class SQLiteStorage
 * @package EventLogger\Storage
 */
class SQLiteStorage implements StorageInterface
{
    /**
     * Table name constant
     */
    const TABLE_NAME = 'event_log';

    /**
     * PDO Connection
     *
     * @var \PDO
     */
    protected $pdo;

    /**
     * Constructor
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Save an event
     *
     * @param array $data
     * @return bool
     */
    public function save(array $data)
    {
        $dataCopy = $data;
        $sql = "INSERT INTO ".self::TABLE_NAME . "(";
        $columns = '';
        $valueParams = '';
        foreach($dataCopy as $key => $value) {
            $columns .= $key . ', ';
            $valueParams .= ':' . $key . ', ';
            if(is_array($value)) {
                $data[$key] = json_encode($value);
            }
        }
        $sql .= rtrim($columns,', ') . ') VALUES (' . rtrim($valueParams, ', ') . ')';
        $stmt = $this->pdo->prepare($sql);
        foreach($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        return $stmt->execute();
    }

    /**
     * Fetch one or more events
     *
     * @param array $criteria
     * @param null $callback
     * @return array
     */
    public function fetch(array $criteria, $callback = null)
    {
        $commonSql = $this->createCommonFetchSql($criteria);
        $sql = 'SELECT * ' . $commonSql;
        $stmt = $this->pdo->prepare($sql);
        foreach($criteria as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();

        $data = array();

        while($record = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if(is_callable($callback)) {
                $record = call_user_func($callback, $record);
            }

            $data[] = $record;
        }

        return $data;
    }

    /**
     * Create a common snippet of SQL for retrieving data
     *
     * @param array $criteria
     * @return string
     */
    private function createCommonFetchSql(array $criteria)
    {
        $sql = 'FROM ' . self::TABLE_NAME. ' ';
        $firstCriteria = TRUE;
        foreach ($criteria as $key => $val) {
            $sql .= ($firstCriteria ? 'WHERE' : 'AND') . ' ' . $key . ' = :' . $key . ' ';
            $firstCriteria = FALSE;
        }
        return $sql;
    }

}