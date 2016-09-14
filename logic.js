var app = angular.module('todo', ['ngMaterial']);
app.controller('todoCtrl', function($scope, $http, $mdDialog) {

    $scope.itemID = null;

    // get all of the todo items from the database
    $scope.items = [];
    var todoItems = $http.get('controller.php');
    // success handler
    todoItems.success( function(data, status, headers, config) {
        angular.forEach(data, function(item) {
            $scope.items.push(item);
        });
    });
    // error handler
    todoItems.error( function(data, status, headers, config) {
        alert(status);
    });

    // show the update todo item dialog
    $scope.showUpdateDialog = function(ev, id) {
        $scope.itemID = id 
        $mdDialog.show({
            contentElement: '#updateItem',
            parent: angular.element(document.body),
         });
    }

    // update an existing todo item
    $scope.updateItem = function(id, note) {
        var data = {id:id, note:note};
        var updated = $http.put('controller.php', data);
        // success handler
        updated.success( function(data, status, headers, config) {
            var stop = false;
            // update the note on the DOM
            angular.forEach($scope.items, function(item) {
                if (stop === false && item.ID === id) {
                    item.note = note;
                    stop = true;
                }
            });
            // set the text field to an empty string
            $scope.updateTodo = '';
            // hide the dialog
            $mdDialog.hide({
                contentElement: '#updateItem'
            });
        });
        // error handler
        updated.error( function(data, status, headers, config) {
            alert(status);
        });
    }

    // delete an existing todo item
    $scope.deleteItem = function(id) {
        var deleted = $http.delete('controller.php/' + id);
        // success handler
        deleted.success( function(data, status, headers, config) {
            location.reload();
        });
        // error handler
        deleted.error( function(data, status, headers, config) {
            alert(status);
        });
    }
 
    // show the new todo item dialog
    $scope.showCreateDialog = function(ev) {
        $mdDialog.show({
            contentElement: '#newItem',
            parent: angular.element(document.body),
         });
    }

    // create a new todo item
    $scope.createItem = function(note) {
        var data = {note:note};
        var created = $http.post('controller.php', data);
        // success handler
        created.success( function(data, status, headers, config) {
            // reload the page
            location.reload();
        });
        created.error( function(data, status, headers, config) {
            alert(status);
        });
    } 

    // close a the dialog windows
    $scope.cancel = function(ev) {
        $mdDialog.hide();
    }
});

