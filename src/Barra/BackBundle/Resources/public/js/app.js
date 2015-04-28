'use strict';

angular.module('angularApp', ['restangular'])
    .config(function($interpolateProvider, $locationProvider, RestangularProvider) {
        $locationProvider.html5Mode(true);
        $interpolateProvider.startSymbol('[[').endSymbol(']]');
        RestangularProvider
            .setFullResponse(true) // to get the location header from POST responses
            .setBaseUrl(Routing.getBaseUrl() + "/api")
            .setDefaultHeaders({Authorization: 'Bearer {'+window.sessionStorage.token+'}'})
            .setResponseExtractor(function(response, operation) {
                return response.data;
            });
    })


    .controller('LoginCtrl', function ($scope, $http, $window) {
        $scope.submit = function () {
            $http.post( Routing.generate('fos_user_security_check', {_locale: 'de'}) , $scope.userdata)
                .success(function (data, status, headers, config) {
                    $window.sessionStorage.token = data.token;
                    $window.location.href = Routing.generate('barra_back_user', {_locale:'de'}); // Symfony's redirect is broken due to JWT-response
                })
                .error(function (data, status, headers, config) {
                    delete $window.sessionStorage.token;
                });
        };
    })



    .controller('RecipesCtrl', function($scope, $http, Restangular) {
        var route               = Routing.generate('barra_api_get_recipes', {offset:0, limit:10, order_by:"name"}); // w/o params is Restangular.all('recipes')
        $scope.recipes          = Restangular.allUrl('recipes', route).getList().$object; // GET some
        $scope.urlRecipeDetail  = Routing.generate('barra_back_recipeDetail', {_locale:'de'});

        /**
         * Post new entity via POST and put validation errors into bootstrap alerts.
         */
        $scope.submit = function () {
            $scope.recipes.post( {'formRecipe':$scope.formData} ).then(
                function(response) {
                    var url     = response.headers('location'),
                        id      = url.substring( url.lastIndexOf('/')+1 ),
                        recipe  = Restangular.one('recipes', id).get().$object;

                    $scope.formData         = null;
                    $scope.formErrors       = null;
                    $scope.formFieldErrors  = null;
                    $scope.recipes.push(recipe);
                    $scope.formRecipe.$setPristine(true);
                },
                function(validationError) {
                    switch (validationError.status) {
                        case 400:
                            $scope.formFieldErrors  = [];
                            $scope.formErrors       = validationError.data.errors.errors;
                            var formFieldErrors     = validationError.data.errors.children;

                            for (var fieldName in formFieldErrors)
                                if (formFieldErrors.hasOwnProperty(fieldName) && formFieldErrors[fieldName].hasOwnProperty('errors'))
                                    $scope.formFieldErrors.push({fieldName: fieldName, errors: formFieldErrors[fieldName].errors});
                            break;
                        case 422:
                            $scope.formErrors = ["Your new entry has a conflict with existing ones. Please check for duplicates and semantic dependencies."];
                    }
                }
            );
        };


        /**
         * Remove entry via DELETE and from scope
         * @param recipe
         */
        $scope.deleteEntry = function(recipe) {
            recipe.remove().then(
                function() {
                    var i = $scope.recipes.indexOf(recipe);
                    $scope.recipes.splice(i, 1);
                    $scope.deleteError = null;
                },
                function() {$scope.deleteError = ["This entry could not be deleted. Please check for semantic dependencies."];}
            );
        };


        /**
         * Triggered when new formFieldErrors were added to check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName == fieldName;
            });
        };
    });