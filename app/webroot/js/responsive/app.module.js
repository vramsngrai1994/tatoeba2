(function() {
    'use strict';

    angular
        .module('app', ['ngMaterial'])
        .config(function($mdThemingProvider, $httpProvider) {
            $mdThemingProvider.theme('default')
                .primaryPalette('green')
                .accentPalette('brown', {'default': '400'});
            $httpProvider.defaults.transformRequest = function(data) {
                if (data === undefined) {
                    return data;
                }
                return $.param(data);
            };
            $httpProvider.defaults.headers.post['Content-Type'] =
                'application/x-www-form-urlencoded; charset=UTF-8';
            $httpProvider.defaults.headers.common['X-Requested-With'] =
                'XMLHttpRequest';
        });
})();