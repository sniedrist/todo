<?php 
// class to CRUD todo objects

// database credentials
require_once('mysqlconfig.php');

class todo {

    // database connection
    private $_database = null;

    public function __construct() {
       // create the database connection
       $this->_database = new mysqli(MYSQL_ENDPOINT, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
       // check the connection
       if ($this->_database->connect_error) {
           exit(sprintf("Database connection failed: %s", $this->_database->connect_error));
       }
       // use utf8 character set
       $this->_database->set_charset('utf8');
    }

    // add a new todo item to the database
    public function createTodo($note=null) {
        $result = null;
        if ($note) {
            $sql = "INSERT INTO `todo` SET `note` = '%s', created = CURRENT_TIMESTAMP";
            $query = sprintf($sql, $this->_database->real_escape_string($note));
            $result = $this->_runQuery($query);
        }
        return $result;
    }

    // get a todo item from the database
    public function getTodo($todoId=null) {
        $result = [];
        if (intval($todoId)) {
            $sql = "SELECT * FROM `todo` WHERE `ID` = %d";
            $query = sprintf($sql, $todoId); 
            $queryResults = $this->_runQuery($query);
            $result = $this->_getRows($queryResults);
        }
        return $result;
    }

    // get all todo items from the database
    public function getAll() {
        $query = $this->_runQuery("SELECT * FROM `todo` LIMIT 1000");
        $result = $this->_getRows($query);
        return $result;
    }

    // update a todo item in the database
    public function updateTodo($todoId=null, $note=null) {
        $result = [];
        if (intval($todoId) and $note) {
            $sql = "UPDATE `todo` SET `note` = '%s' WHERE `ID` = %d";
            $query = sprintf($sql, $this->_database->real_escape_string($note), $todoId); 
            $result = $this->_runQuery($query);
        }
        return $result;
    }

    // delete a todo item from the database
    public function deleteTodo($todoId=null) {
        $result = [];
        if (intval($todoId)) {
            $sql = "DELETE FROM `todo` WHERE `ID` = %d";
            $query = sprintf($sql, $todoId);
            $result = $this->_runQuery($query);
        }
        return $result;
    }

    // run a SQL query
    private function _runQuery($query=null) {
        $result = null;
        if ($query) {
            $result = $this->_database->query($query);
        }
        if (!$result) {
            http_response_code(404);
            exit($this->_database->error);
        }
        return $result;
    }

    // return an array of database query results
    private function _getRows($data=null) {
        $result = [];
        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function __destruct() {
        // close the database connection
        $this->_database->close();
    }
}
?>
