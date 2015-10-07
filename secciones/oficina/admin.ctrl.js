/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('AdminController', function($scope, $rootScope, PageValues, Usuarios, $routeParams,
                                            triSettings, triLayout, $mdDialog, $q)  {
        //Set page title and description
        PageValues.title = "Admin";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

        vm.vista = $rootScope.vista;


        // we need to use the scope here because otherwise the expression in md-is-locked-open doesnt work
        $scope.layout = triLayout.layout; //eslint-disable-line
        vm.layout = triLayout.layout; //eslint-disable-line
        //var vm = this;






        //tabla
        vm.columns = [{
            title: '',
            field: 'thumb',
            sortable: false,
            filter: 'tableImage'
        },{
            title: 'Name',
            field: 'name',
            sortable: true
        },{
            title: 'Description',
            field: 'description',
            sortable: true
        },{
            title: 'Date of Birth',
            field: 'birth',
            sortable: true
        }];

        vm.contents = [{
            thumb:'assets/plantillas/admin/img/avatars/avatar-1.png',
            name: 'Chris Doe',
            description: 'Developer',
            birth: 'Jun 5, 1994'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-2.png',
            name: 'Ann Doe',
            description: 'Commerce',
            birth: 'Jul 15, 1993'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-3.png',
            name: 'Mark Ronson',
            description: 'Designer',
            birth: 'Jan 27, 1984'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-4.png',
            name: 'Eric Doe',
            description: 'Human Resources',
            birth: 'Feb 3, 1985'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-5.png',
            name: 'John Doe',
            description: 'Commerce',
            birth: 'Sep 5, 1978'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-1.png',
            name: 'George Doe',
            description: 'Media',
            birth: 'Jun 23, 1996'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-2.png',
            name: 'Ann Ronson',
            description: 'Commerce',
            birth: 'Aug 16, 1995'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-3.png',
            name: 'Adam Ronson',
            description: 'Developer',
            birth: 'Jan 7, 1987'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-4.png',
            name: 'Hansel Doe',
            description: 'Social Media',
            birth: 'Feb 13, 1977'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-5.png',
            name: 'Tony Doe',
            description: 'CEO',
            birth: 'Sep 29, 1970'
        }];


    });