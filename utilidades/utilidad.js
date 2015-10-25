/**
 * Created by Alejandro on 23/10/2015.
 */

var Utilidades = Utilidades || {};

Utilidades.LocalStorage = {

    disponibleLocalStorage:  function() {

        var storageType = 'localStorage';

        var isStorageAvailable = (function() {
        try {
            var supported = storageType in window && window[storageType] !== null;

            if (supported) {
                var key = Math.random().toString(36).substring(7);
                window[storageType].setItem(key, '');
                window[storageType].removeItem(key);
            }

            return supported;
        } catch (e) {
            return false;
        }
        })();

        if (!isStorageAvailable) {
            console.warn('Satellizer Warning: ' + storageType + ' is not available.');
        }

        return {
            get: function (key) {
                return isStorageAvailable ? window[storageType].getItem(key) : undefined;
            },
            set: function (key, value) {
                return isStorageAvailable ? window[storageType].setItem(key, value) : undefined;
            },
            remove: function (key) {
                return isStorageAvailable ? window[storageType].removeItem(key) : undefined;
            }
        }
    },
    getIdUsuarioActual: function() {
        return this.disponibleLocalStorage().get('u_i');
    },
    getNombreUsuarioActual: function() {
        return this.disponibleLocalStorage().get('u_n');
    }
};