/**
 * Created by alejandro.sosa on 20/10/2015.
 */

'use strict';
angular
    .module('app.coreoficina')
    .directive('usuarioDatoUnico', function(Usuarios) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, element, attrs, ngModel) {
                element.bind('blur', function (e) {
                    if (!ngModel || !element.val()) return;
                    var campo = scope.$eval(attrs.usuarioDatoUnico);
                    var valor = element.val();

                    Usuarios.existedatousuario(campo.propiedad, valor)
                        .then(function (existe) {
                            //aseguramos que el valor no ha cambiado
                            //desde la llamada realizada
                            if (valor == element.val()) {
                                ngModel.$setValidity('unico', existe);
                            }
                        }, function () {
                            //Probably want a more robust way to handle an error
                            //For this demo we'll set unique to true though
                            ngModel.$setValidity('unico', true);
                        });
                }); //fin link
            }
        };
    })