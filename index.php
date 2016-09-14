<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Todo items</title>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
        <link rel="stylesheet" href="style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
        <script src="logic.js"></script>
    </head>
    <body>
        <div data-ng-app="todo" data-ng-controller="todoCtrl">
            <h1>Todo Items</h1>
            <md-list md-cols="4" md-row-height="fit" class="mdList">
                <md-list-item data-ng-repeat="item in items">
                    <p>{{item.note}}</p>
                    <md-button class="md-raised" data-ng-click="showUpdateDialog($event, item.ID)">Update</md-button>
                    <md-button class="md-raised" data-ng-click="deleteItem(item.ID)">Delete</md-button>
                </md-list-item>
            </md-list>
            <md-button class="md-raised" data-ng-click="showCreateDialog($event)">Create New</md-button>
            <div class="hidden">
                <div class="md-dialog-container" id="newItem">
                    <md-dialog>
                        <md-subheader>Add a new todo item.</md-subheader>
                        <md-input-container>
                            <input type="text" aria-label="new todo item" data-ng-model="newTodo">
                            <md-button class="md-raised" data-ng-click="createItem(newTodo)">Create Item</md-button>
                            <md-button class="md-raised" data-ng-click="cancel($event)">Cancel</md-button>
                        </md-input-container>
                    </md-dialog>
                </div>
                <div class="md-dialog-container" id="updateItem">
                    <md-dialog>
                        <md-subheader>Update a todo item.</md-subheader>
                        <md-input-container>
                            <input type="text" aria-label="new todo item" data-ng-model="updateTodo">
                            <md-button class="md-raised" data-ng-click="updateItem(itemID, updateTodo)">Update Item</md-button>
                            <md-button class="md-raised" data-ng-click="cancel($event)">Cancel</md-button>
                        </md-input-container>
                    </md-dialog>
                </div>
            </div>
        </div>
    </body>
</html>
