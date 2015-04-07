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
        var baseRecipes         = Restangular.all('recipes'),
            route               = Routing.generate('barra_api_get_recipes_limited', {offset:0, limit:10, order_by:"name"});

        $scope.recipes          = Restangular.allUrl('someRecipes', route).getList().$object; // GET some
        $scope.urlRecipeDetail  = Routing.generate('barra_back_recipeDetail', {_locale:'de'});
        $scope.urlRecipeDelete  = Routing.generate('barra_back_recipe_delete', {_locale:'de'});

        $scope.submit = function () {
            var form = {'formRecipe': $scope.formData};
            baseRecipes.post(form).then(
                function(response) {
                    $scope.formErrors = null;
                    $scope.formFieldErrors = null;


                    var x = Restangular.oneUrl('getPosted', response.headers('location'));
                    $scope.recipes.push( x );
                    console.log( x );

                    /*entities[i]['activeTr'].addClass('success');
                    setTimeout(function() {
                        entities[i]['activeTr'].removeClass('success');
                        entities[i]['activeTr'] = null;
                    }, 1500);*/
                },
                function(validationError) {
                    switch (validationError.status) {
                        case 400:
                            $scope.formErrors = validationError.data.errors.errors;

                            var formFieldErrors = validationError.data.errors.children;
                            for (var fieldName in formFieldErrors)
                                if (formFieldErrors.hasOwnProperty(fieldName) && formFieldErrors[fieldName].hasOwnProperty('errors')) { // field with errors?
                                    if ($scope.formFieldErrors === undefined) $scope.formFieldErrors = [];
                                    $scope.formFieldErrors.push({fieldName: fieldName, errors: formFieldErrors[fieldName].errors});
                                }
                            break;
                        case 422:
                            $scope.formErrors = ["Your new entry has a conflict with existing ones. Please check for duplicates and semantic dependencies"];
                    }
                }
            );
        };

        /**
         * Triggered when new formFieldErrors were added to check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName === fieldName;
            });
        };
    });




























//$scope.recipes      = baseRecipes.getList().$object;                    // GET all
//$scope.recipe       = Restangular.one('recipes', 4379).get().$object;   // GET one