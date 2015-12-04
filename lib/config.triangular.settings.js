
    'use strict';

    angular
        .module('app.coreoficina')
        .config(translateConfig);

    /* @ngInject */
    function translateConfig(triSettingsProvider) {
        // set app name & logo (used in loader, sidemenu, login pages, etc)
        triSettingsProvider.setName('JA');
        triSettingsProvider.setLogo('assets/plantillas/admin/img/logo.png');
        // set current version of app (shown in footer)
        triSettingsProvider.setVersion('2.1.0');

        // setup available languages in triangular
        /*for (var lang = APP_LANGUAGES.length - 1; lang >= 0; lang--) {
            triSettingsProvider.addLanguage({
                name: APP_LANGUAGES[lang].name,
                key: APP_LANGUAGES[lang].key
            });
        }*/
    }