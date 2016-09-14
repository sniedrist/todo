<?php
// endpoint for AJAX requests

// require todo to interact with todo objects
require_once('todo.php');

class controller {

    // request method
    private $_method = null;
    // url parameter 
    private $_request = null;
    // input data
    private $_input = null;
    // todo object
    private $_todo = null;

    public function __construct() {

        $this->_method = $_SERVER['REQUEST_METHOD'];
        $this->_request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
        $this->_input = json_decode(file_get_contents('php://input'), true);
        $this->_todo = new todo();

        switch ($this->_method) {
            // get todo items
            case 'GET':
                // get a specific todo item
                if (isset($this->_request[0]) && $this->_request->_request[0] != '') {
                    print json_encode($this->_todo->getTodo($this->_request[0]));
                }
                // get all todo items
                else {
                    print json_encode($this->_todo->getAll());
                }
                break;

            // create a new todo item
            case 'POST':
                if (isset($this->_input['note'])) {
                    print $this->_todo->createTodo($this->_input['note']);
                }
                else {
                    print -1;
                }
                break;

            // update an existing todo item
            case 'PUT':
                if (isset($this->_input['id']) && isset($this->_input['note'])) {
                    print $this->_todo->updateTodo($this->_input['id'], $this->_input['note']);
                }
                else {
                    print -1;
                }
                break;

            // delete an existing todo item
            case 'DELETE':
                if (isset($this->_request[0]) && $this->_request[0] != '') {
                    print $this->_todo->deleteTodo($this->_request[0]);
                }
                else {
                    print -1;
                }
                break;
        } 
    }
}

new controller();
?>

