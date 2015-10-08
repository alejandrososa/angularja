(function() {
    'use strict';

    angular
        .module('app.coreoficina')
        .filter('tableImage', tableImage)
        .constant("CONFIG_TABLA", {
            "IMAGEN": "assets/plantillas/admin/img/avatars/avatar-5.png",
        });

    function tableImage($sce, CONFIG_TABLA) {
        return filterFilter;

        ////////////////

        function filterFilter(value) {
            var imagen = value || CONFIG_TABLA.IMAGEN;
            return $sce.trustAsHtml('<div style=\"background-image: url(\'' + imagen + '\')\"/>');
        }
    }

})();