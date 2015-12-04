/**
 * Created by Alejandro on 04/10/2015.
 */
'use strict';

angular
    .module('app.coreoficina')
    .config(config);

/* @ngInject */
function config(triLayoutProvider) {
    triLayoutProvider.setDefaultOption('toolbarSize', 'default');

    triLayoutProvider.setDefaultOption('toolbarShrink', true);

    triLayoutProvider.setDefaultOption('toolbarClass', '');

    triLayoutProvider.setDefaultOption('contentClass', '');

    triLayoutProvider.setDefaultOption('sideMenuSize', 'full');

    triLayoutProvider.setDefaultOption('showToolbar', true);

    triLayoutProvider.setDefaultOption('footer', true);
}