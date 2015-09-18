/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.core')
    .controller('AdminController', function($scope, PageValues) {
        //Set page title and description
        PageValues.title = "Admin";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

    });