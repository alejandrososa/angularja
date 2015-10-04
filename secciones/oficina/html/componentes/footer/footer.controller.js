(function() {
    'use strict';

    angular
        .module('app.coreoficina')
        .controller('FooterController', FooterController);

    /* @ngInject */
    function FooterController(triSettings, triLayout) {
        var vm = this;
        vm.name = triSettings.name;
        vm.date = new Date();
        vm.layout = triLayout.layout;
        vm.version = triSettings.version;
    }
})();