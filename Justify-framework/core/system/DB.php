<?php

namespace Justify\System;

use PDO;
use PDOException;
use Justify;
use Justify\Exceptions\ExtensionNotFoundException;

/**
 * Class DB
 *
 * System class DB consists of simple methods for work with DB
 *
 * @since 2.0
 * @package Justify\System
 */
class DB extends Model
{
    /**
     * PDO resource
     *
     * @var PDO
     */
    private $db;

    /**
     * Table name
     *
     * @var string
     */
    private $table;

    /**
     * SQL query
     *
     * @var string
     */
    private $query;

    /**
     * SQL query params
     *
     * @var array
     */
    private $params = [];

    /**
     * Starts SQL query
     * 
     * Makes SQL query "SELECT * FROM table" and returns object
     * 
     * @return object
     */
    public static function find()
    {
        $object = new static();
        $object->query = "SELECT * FROM {$object->table}";

        return $object;
    }

    /**
     * Returns object of one data
     * 
     * @param int $identify record identify
     * @param string $identifyName name of identifier
     * @return object
     */
    public static function findOne($identify, $identifyName = 'id')
    {
        $object = new static();
        $stmt = $object->db->prepare("SELECT * FROM {$object->table} WHERE $identifyName = ?");
        $stmt->execute([$identify]);

        return $stmt->fetch();
    }

    /**
     * Returns total count of all records
     * 
     * @return int
     */
    public static function totalCount()
    {
        $object = new static();
        $stmt = $object->db->query("SELECT COUNT(*) as count FROM {$object->table}");

        return intval($stmt->fetch()->count);
    }

    /**
     * Returns array of all data
     * 
     * @return array
     */
    public static function findAll()
    {
        $object = new static();
        $stmt = $object->db->query("SELECT * FROM {$object->table}");

        return $stmt->fetchAll();
    }

    /**
     * Execs your SQL query and returns result
     *
     * @param string $query SQL query
     * @return int
     */
    public static function exec($query)
    {
        $object = new static();

        return $object->db->exec($query);
    }

    /**
     * Clears all table data
     *
     * @return int
     */
    public static function clearTable()
    {
        $object = new static();

        return $object->exec("TRUNCATE TABLE {$object->table}");
    }

    /**
     * Drops table
     *
     * @return int
     */
    public static function dropTable()
    {
        $object = new static();

        return $object->exec("DROP TABLE {$object->table}");
    }

    /**
     * Drops data base
     *
     * @return int
     */
    public static function dropDB()
    {
        $object = new static();

        return $object->exec("DROP DATABASE " . Justify::$settings['db']['name']);
    }

    /**
     * Sets SQL query from find() method
     * 
     * Sets "SELECT columns"
     *
     * @param string|array $select selects items
     * @return object
     */
    public function select($select)
    {
        if (is_array($select)) {
            $this->query = "SELECT " . implode(', ', $select);
        } else {
            $this->query = "SELECT $select";
        }

        return $this;
    }

    /**
     * Sets SQL query from find() method
     * 
     * Sets "SELECT COUNT(columns)"
     * Use it to discover to count of rows from SQL query
     *
     * @param string|array $select selects items
     * @return object
     */
    public function selectCount($select)
    {
        if (is_array($select)) {
            $this->query = "SELECT COUNT(" . implode(', ', $select) . ')';
        } else {
            $this->query = "SELECT COUNT($select)";
        }

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "FROM table"
     *
     * @param string $from from table name
     * @return object
     */
    public function from($from)
    {
        $this->query .= " FROM $from";

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "WHERE condition"
     *
     * @param string $condition condition of where
     * @param array $params array of values
     * @return object
     */
    public function where($condition, $params = [])
    {
        $this->query .= " WHERE $condition";
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "AND WHERE condition"
     *
     * @param string $condition condition of where
     * @param array $params array of values
     * @return object
     */
    public function andWhere($condition, $params = [])
    {
        $this->query .= " AND WHERE $condition";
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "OR WHERE condition"
     *
     * @param string $condition condition of where
     * @param array $params array of values
     * @return object
     */
    public function orWhere($condition, $params = [])
    {
        $this->query .= " OR WHERE $condition";
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "ORDER BY column sort_method"
     *
     * @param string $column column name
     * @param string $sort sort method
     * @return object
     */
    public function orderBy($column, $sort = 'ASC')
    {
        $this->query .= " ORDER BY $column $sort";

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "LIMIT number"
     *
     * @param int $limit limit of SQL query
     * @return object
     */
    public function limit($limit)
    {
        $this->query .= " LIMIT ?";
        $this->params = array_merge($this->params, [$limit]);

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "OFFSET number"
     *
     * @param int $offset offset of SQL query
     * @return object
     */
    public function offset($offset)
    {
        $this->query .= " OFFSET ?";
        $this->params = array_merge($this->params, [$offset]);

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "GROUP BY column"
     *
     * @param string $column column name
     * @return object
     */
    public function groupBy($column)
    {
        $this->query .= " GROUP BY $column";

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "INNER JOIN table ON condition"
     *
     * @param string $table joins table
     * @param string $on join condition
     * @return object
     */
    public function join($table, $on)
    {
        $this->query .= " INNER JOIN $table ON $on";

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "LEFT JOIN table ON condition"
     *
     * @param string $table joins table
     * @param string $on join condition
     * @return object
     */
    public function leftJoin($table, $on)
    {
        $this->query .= " LEFT JOIN $table ON $on";

        return $this;
    }

    /**
     * Continues SQL query from find() method
     * 
     * Concats "RIGHT JOIN table ON condition"
     *
     * @param string $table joins table
     * @param string $on join condition
     * @return object
     */
    public function rightJoin($table, $on)
    {
        $this->query .= " RIGHT JOIN $table ON $on";

        return $this;
    }

    /**
     * Execs SQL query from find() method and returns array of data
     * 
     * @return array
     */
    public function all()
    {
        $stmt = $this->db->prepare($this->query);
        $stmt->execute($this->params);

        return $stmt->fetchAll();
    }

    /**
     * Execs SQL query from find() method and returns object of one data
     * 
     * @return object
     */
    public function one()
    {
        $stmt = $this->db->prepare($this->query);
        $stmt->execute($this->params);

        return $stmt->fetch();
    }

    /**
     * Execs SQL query from find() method and returns count of selected rows
     * 
     * It's slow method, be careful then using it 
     * 
     * @return int
     */
    public function count()
    {
        $stmt = $this->db->prepare($this->query);
        $stmt->execute($this->params);
        
        return $stmt->rowCount();
    }

    /**
     * Sets conntection for MySQL DBMS
     * 
     * @since 2.1.0
     * @return object
     */
    private function connectMysql($settings, $pdoOptions)
    {
        return new PDO(
            "mysql:host={$settings['host']};"
            . "dbname={$settings['name']};"
            . "charset={$settings['charset']}",
            $settings['user'],
            $settings['password'],
            $pdoOptions
        );
    }

    /**
     * Sets conntection for PostgreSQL DBMS
     * 
     * @since 2.1.0
     * @return object
     */
    private function connectPgsql($settings, $pdoOptions)
    {
        return new PDO(
            "pgsql:host={$settings['host']};"
            . "dbname={$settings['name']};"
            . "charset={$settings['charset']}",
            $settings['user'],
            $settings['password'],
            $pdoOptions
        );
    }

    /**
     * Sets conntection for SQLite DBMS
     * 
     * @since 2.1.0
     * @return object
     */
    private function connectSqlite($settings, $pdoOptions)
    {
        return new PDO(
            'sqlite:' . $settings['path'],
            null, null,
            $pdoOptions
        );
    }

    /**
     * Method provides connection this DB
     *
     * Change DB connecting properties in config/db.php
     */
    public function __construct()
    {
        $dbSettings = Justify::$settings['db'];
        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            if (! extension_loaded('PDO')) {
                throw new ExtensionNotFoundException('PDO');
            }

            if ($dbSettings['dbms'] == 'mysql') {
                $this->db = $this->connectMysql($dbSettings['mysql'], $pdoOptions);
            }
            if ($dbSettings['dbms'] == 'pgsql') {
                $this->db = $this->connectPgsql($dbSettings['pgsql'], $pdoOptions);
            }
            if ($dbSettings['dbms'] == 'sqlite') {
                $this->db = $this->connectPgsql($dbSettings['sqlite'], $pdoOptions);
            }

            $this->table = static::tableName();
            
        } catch (PDOException $e) {
            if (Justify::$debug) {
                echo '<b>PDO Exception: </b>';
                echo $e->getMessage();
            }
            exit();
        } catch (ExtensionNotFoundException $e) {
            $e->printError();
            exit();
        }
    }

    /**
     * Nullifies data base connection
     */
    public function __destruct()
    {
        $this->db = null;
    }
}