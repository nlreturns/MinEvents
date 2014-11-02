<?php

/**
 * MysqliDb Class
 *
 * @category  Database Access
 * @package   MysqliDb
 * @author    Jeffery Way <jeffrey@jeffrey-way.com>
 * @author    Josh Campbell <jcampbell@ajillion.com>
 * @author    Alexander V. Butenko <a.butenka@gmail.com>
 * @copyright Copyright (c) 2010
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   2.0
 * */
class MysqliDb {

    /**
     * MySQLi instance
     *
     * @var mysqli
     */
    protected $mysqli;

    /**
     * The SQL query to be prepared and executed
     *
     * @var string
     */
    protected $query;

    /**
     * The previously executed SQL query
     *
     * @var string
     */
    protected $lastQuery;

    /**
     * An array that holds where joins
     *
     * @var array
     */
    protected $join = array();

    /**
     * An array that holds where conditions 'fieldname' => 'value'
     *
     * @var array
     */
    protected $where = array();

    /**
     * Database credentials
     *
     * @var string
     */
    protected $host;
    protected $username;
    protected $password;
    protected $db;
    protected $port;

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $db
     * @param int $port
     */
    public function __construct($host = NULL, $username = NULL, $password = NULL, $db = NULL, $port = NULL) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        if ($port == NULL)
            $this->port = ini_get('mysqli.default_port');
        else
            $this->port = $port;

        if ($host == null && $username == null && $db == null) {
            $this->isSubQuery = true;
            return;
        }

        // for subqueries we do not need database connection and redefine root instance
        $this->connect();
        $this->setPrefix();
        self::$_instance = $this;
    }

    /**
     * A method to connect to the database
     *
     */
    public function connect() {
        if ($this->isSubQuery)
            return;

        $this->_mysqli = new mysqli($this->host, $this->username, $this->password, $this->db, $this->port) or die('There was a problem connecting to the database');

        $this->_mysqli->set_charset('utf8');
    }

    /**
     * Reset states after an execution
     *
     * @return object Returns the current instance.
     */
    protected function reset() {
        $this->_where = array();
        $this->_join = array();
        $this->_orderBy = array();
        $this->_groupBy = array();
        $this->_bindParams = array(''); // Create the empty 0 index
        $this->_query = null;
        $this->count = 0;
    }

    /**
     * Pass in a raw query and an array containing the parameters to bind to the prepaird statement.
     *
     * @param string $query      Contains a user-provided query.
     * @param array  $bindParams All variables to bind to the SQL statment.
     * @param bool   $sanitize   If query should be filtered before execution
     *
     * @return array Contains the returned rows from the query.
     */
    public function rawQuery($query, $bindParams = null, $sanitize = true) {
        $this->_query = $query;
        if ($sanitize)
            $this->_query = filter_var($query, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $stmt = $this->_prepareQuery();

        if (is_array($bindParams) === true) {
            $params = array(''); // Create the empty 0 index
            foreach ($bindParams as $prop => $val) {
                $params[0] .= $this->_determineType($val);
                array_push($params, $bindParams[$prop]);
            }

            call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
        }

        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();

        return $this->_dynamicBindResults($stmt);
    }

    /**
     *
     * @param string $query   Contains a user-provided select query.
     * @param int    $numRows The number of rows total to return.
     *
     * @return array Contains the returned rows from the query.
     */
    public function query($query, $numRows = null) {
        $this->_query = filter_var($query, FILTER_SANITIZE_STRING);
        $stmt = $this->_buildQuery($numRows);
        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();

        return $this->_dynamicBindResults($stmt);
    }

    /**
     * Update query. Be sure to first call the "where" method.
     *
     * @param string $tableName The name of the database table to work with.
     * @param array  $tableData Array of data to update the desired row.
     *
     * @return boolean
     */
    public function update($tableName, $tableData) {
        if ($this->isSubQuery)
            return;

        $this->_query = "UPDATE " . self::$_prefix . $tableName . " SET ";

        $stmt = $this->_buildQuery(null, $tableData);
        $status = $stmt->execute();
        $this->reset();
        $this->_stmtError = $stmt->error;
        $this->count = $stmt->affected_rows;

        return $status;
    }

    /**
     * Delete query. Call the "where" method first.
     *
     * @param string  $tableName The name of the database table to work with.
     * @param integer $numRows   The number of rows to delete.
     *
     * @return boolean Indicates success. 0 or 1.
     */
    public function delete($tableName, $numRows = null) {
        if ($this->isSubQuery)
            return;

        $this->_query = "DELETE FROM " . self::$_prefix . $tableName;

        $stmt = $this->_buildQuery($numRows);
        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();

        return ($stmt->affected_rows > 0);
    }

    /**
     * This method allows you to specify multiple (method chaining optional) AND WHERE statements for SQL queries.
     *
     * @uses $MySqliDb->where('id', 7)->where('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     *
     * @return MysqliDb
     */
    public function where($whereProp, $whereValue = null, $operator = null) {
        if ($operator)
            $whereValue = Array($operator => $whereValue);

        $this->_where[] = Array("AND", $whereValue, $whereProp);
        return $this;
    }

    /**
     * This method allows you to specify multiple (method chaining optional) OR WHERE statements for SQL queries.
     *
     * @uses $MySqliDb->orWhere('id', 7)->orWhere('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     *
     * @return MysqliDb
     */
    public function orWhere($whereProp, $whereValue = null, $operator = null) {
        if ($operator)
            $whereValue = Array($operator => $whereValue);

        $this->_where[] = Array("OR", $whereValue, $whereProp);
        return $this;
    }

    /**
     * This method allows you to concatenate joins for the final SQL statement.
     *
     * @uses $MySqliDb->join('table1', 'field1 <> field2', 'LEFT')
     *
     * @param string $joinTable The name of the table.
     * @param string $joinCondition the condition.
     * @param string $joinType 'LEFT', 'INNER' etc.
     *
     * @return MysqliDb
     */
    public function join($joinTable, $joinCondition, $joinType = '') {
        $allowedTypes = array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER');
        $joinType = strtoupper(trim($joinType));
        $joinTable = filter_var($joinTable, FILTER_SANITIZE_STRING);

        if ($joinType && !in_array($joinType, $allowedTypes))
            die('Wrong JOIN type: ' . $joinType);

        $this->_join[$joinType . " JOIN " . self::$_prefix . $joinTable] = $joinCondition;

        return $this;
    }

    /**
     * This method allows you to specify multiple (method chaining optional) ORDER BY statements for SQL queries.
     *
     * @uses $MySqliDb->orderBy('id', 'desc')->orderBy('name', 'desc');
     *
     * @param string $orderByField The name of the database field.
     * @param string $orderByDirection Order direction.
     *
     * @return MysqliDb
     */
    public function orderBy($orderByField, $orderbyDirection = "DESC") {
        $allowedDirection = Array("ASC", "DESC");
        $orderbyDirection = strtoupper(trim($orderbyDirection));
        $orderByField = preg_replace("/[^-a-z0-9\.\(\),_]+/i", '', $orderByField);

        if (empty($orderbyDirection) || !in_array($orderbyDirection, $allowedDirection))
            die('Wrong order direction: ' . $orderbyDirection);

        $this->_orderBy[$orderByField] = $orderbyDirection;
        return $this;
    }

    /**
     * This method allows you to specify multiple (method chaining optional) GROUP BY statements for SQL queries.
     *
     * @uses $MySqliDb->groupBy('name');
     *
     * @param string $groupByField The name of the database field.
     *
     * @return MysqliDb
     */
    public function groupBy($groupByField) {
        $groupByField = preg_replace("/[^-a-z0-9\.\(\),_]+/i", '', $groupByField);

        $this->_groupBy[] = $groupByField;
        return $this;
    }

    /**
     * This methods returns the ID of the last inserted item
     *
     * @return integer The last inserted item ID.
     */
    public function getInsertId() {
        return $this->_mysqli->insert_id;
    }

    /**
     * Escape harmful characters which might affect a query.
     *
     * @param string $str The string to escape.
     *
     * @return string The escaped string.
     */
    public function escape($str) {
        return $this->_mysqli->real_escape_string($str);
    }

    /**
     * Abstraction method that will compile the WHERE statement,
     * any passed update data, and the desired rows.
     * It then builds the SQL query.
     *
     * @param int   $numRows   The number of rows total to return.
     * @param array $tableData Should contain an array of data for updating the database.
     *
     * @return mysqli_stmt Returns the $stmt object.
     */
    protected function _buildQuery($numRows = null, $tableData = null) {
        $this->_buildJoin();
        $this->_buildTableData($tableData);
        $this->_buildWhere();
        $this->_buildGroupBy();
        $this->_buildOrderBy();
        $this->_buildLimit($numRows);

        $this->_lastQuery = $this->replacePlaceHolders($this->_query, $this->_bindParams);

        if ($this->isSubQuery)
            return;

        // Prepare query
        $stmt = $this->_prepareQuery();

        // Bind parameters to statement if any
        if (count($this->_bindParams) > 1)
            call_user_func_array(array($stmt, 'bind_param'), $this->refValues($this->_bindParams));

        return $stmt;
    }

    /**
     * Abstraction method that will build an INSERT or UPDATE part of the query
     */
    protected function _buildTableData($tableData) {
        if (!is_array($tableData))
            return;

        $isInsert = strpos($this->_query, 'INSERT');
        $isUpdate = strpos($this->_query, 'UPDATE');

        if ($isInsert !== false) {
            $this->_query .= '(`' . implode(array_keys($tableData), '`, `') . '`)';
            $this->_query .= ' VALUES(';
        }

        foreach ($tableData as $column => $value) {
            if ($isUpdate !== false)
                $this->_query .= "`" . $column . "` = ";

            // Subquery value
            if (is_object($value)) {
                $this->_query .= $this->_buildPair("", $value) . ", ";
                continue;
            }

            // Simple value
            if (!is_array($value)) {
                $this->_bindParam($value);
                $this->_query .= '?, ';
                continue;
            }

            // Function value
            $key = key($value);
            $val = $value[$key];
            switch ($key) {
                case '[I]':
                    $this->_query .= $column . $val . ", ";
                    break;
                case '[F]':
                    $this->_query .= $val[0] . ", ";
                    if (!empty($val[1]))
                        $this->_bindParams($val[1]);
                    break;
                case '[N]':
                    if ($val == null)
                        $this->_query .= "!" . $column . ", ";
                    else
                        $this->_query .= "!" . $val . ", ";
                    break;
                default:
                    die("Wrong operation");
            }
        }
        $this->_query = rtrim($this->_query, ', ');
        if ($isInsert !== false)
            $this->_query .= ')';
    }

    /**
     * Method attempts to prepare the SQL query
     * and throws an error if there was a problem.
     *
     * @return mysqli_stmt
     */
    protected function _prepareQuery() {
        if (!$stmt = $this->_mysqli->prepare($this->_query)) {
            trigger_error("Problem preparing query ($this->_query) " . $this->_mysqli->error, E_USER_ERROR);
        }
        return $stmt;
    }

    /**
     * Close connection
     */
    public function __destruct() {
        if (!$this->isSubQuery)
            return;
        if ($this->_mysqli)
            $this->_mysqli->close();
    }

    /**
     * Method returns last executed query
     *
     * @return string
     */
    public function getLastQuery() {
        return $this->_lastQuery;
    }

    /**
     * Method returns mysql error
     * 
     * @return string
     */
    public function getLastError() {
        return $this->_stmtError . " " . $this->_mysqli->error;
    }

    /**
     * Mostly internal method to get query and its params out of subquery object
     * after get() and getAll()
     * 
     * @return array
     */
    public function getSubQuery() {
        if (!$this->isSubQuery)
            return null;

        array_shift($this->_bindParams);
        $val = Array('query' => $this->_query,
            'params' => $this->_bindParams
        );
        $this->reset();
        return $val;
    }

}

// END class