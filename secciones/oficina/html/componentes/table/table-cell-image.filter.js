    'use strict';

    angular
        .module('app.coreoficina')
        .filter('tableImage', tableImage)
        .filter('tablaFecha', tablafecha)
        .filter('capitalize', capitalize)
        .constant("CONFIG_TABLA", {
            IMAGEN: "assets/plantillas/admin/img/avatars/avatar-5.png",
        });

    function tableImage($sce, CONFIG_TABLA) {
        return filterFilter;

        ////////////////

        function filterFilter(value) {
            var imagen = value || CONFIG_TABLA.IMAGEN;
            return $sce.trustAsHtml('<div class=\"imagenTabla\" style=\"background-image: url(\'' + imagen + '\')\"/>');
            //return '-<img src=\"' + imagen + '\"/>';
        }
    }

    function tablafecha() {
        return filterFilter;

        ////////////////

        function filterFilter(value) {
            var imagen = value; // || CONFIG_TABLA.IMAGEN;

            return moment(value).format("DD-MM-YY");
        }
    }

    function capitalize() {
        return filter;

        function filter(input) {
            if (input !== null) {
                return input.replace(/\w\S*/g, function(txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            }
        }
    }