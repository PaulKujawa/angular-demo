'use strict';

angular.module('angularApp', ['restangular'])
    .config(function($locationProvider, RestangularProvider) {
        $locationProvider.html5Mode(true); // no # in routes even though not used yet (requires <base> in <head>)

        RestangularProvider
            .setBaseUrl(Routing.getBaseUrl() + "/api")
            .setDefaultHeaders({Authorization: 'Bearer {'+window.sessionStorage.token+'}'})
            .setResponseExtractor(function(response, operation) {
                return response.data;
            });
    })

    .controller('LoginCtrl', function ($scope, $http, $window) { // user login and saving the responded JWT-token
        $scope.submit = function () {
            $http.post( Routing.generate('fos_user_security_check', {_locale: 'de'}) , $scope.userdata)
                .success(function (data, status, headers, config) {
                    $window.sessionStorage.token = data.token
                })
                .error(function (data, status, headers, config) {
                    delete $window.sessionStorage.token;
                });
        };
    })

    .controller('RecipesCtrl', function($scope, $http, Restangular) {
        var baseRecipes     = Restangular.all('recipes');
        $scope.recipes      = baseRecipes.getList().$object;                    // GET list
        $scope.recipe       = Restangular.one('recipes', 4379).get().$object;   // GET one

        var newRecipe = {'formRecipe': {name: "angular's POST"}};               // POST one
        baseRecipes.post(newRecipe);
    });

