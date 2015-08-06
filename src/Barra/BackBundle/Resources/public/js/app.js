'use strict';

angular.module('angularApp', ['restangular', 'chart.js', 'ui.tree'])
    .config(function($interpolateProvider, $locationProvider, RestangularProvider) {
        $locationProvider.html5Mode(true);
        $interpolateProvider.startSymbol('[[').endSymbol(']]');
        RestangularProvider
            .setFullResponse(true) // to get the location header from POST responses
            .setBaseUrl(Routing.getBaseUrl() + '/api')
            .setDefaultHeaders({Authorization: 'Bearer {'+window.sessionStorage.token+'}'})
            .setResponseExtractor(function(response, operation) {
                return response.data;
            });
    })
    .factory('Api', function(Restangular) {
        return {
            post: function(collection, formData, formName) {
                var requestJSON           = {};
                requestJSON[formName] = formData;

                return collection.post(requestJSON);
            },
            put: function(collection, object, formName, formData) {
                var requestJSON             = {};
                requestJSON[formName]   = formData;

                return object.customPUT(requestJSON);
            },
            get: function(path, id) {
                return Restangular.one(path, id).get();
            }
        };
    })
    .factory('FormError', function() {
        return {
            selectMsg: function(validationError) {
                switch (validationError.status) {
                    case 400:
                        return validationError.data.errors.errors;
                    case 401:
                        return ['(400) Bad credentials.'];
                    case 403:
                        return ['(403) You are not authorized to access this project.'];
                    case 409:
                        return ['(409) This entry could not be deleted. Please check for semantic dependencies.'];
                    case 422:
                        return ['(422) Your new entry has a conflict with existing ones. Please check for duplicates and semantic dependencies.'];
                    default :
                        return ['(500) A server error occurred. Please contact the administrator for support.'];
                }
            }
        }
    })
    .factory('FormFieldError', function() {
        return {
            selectMsg: function(formChildren) {
                var formFieldErrors = [];
                for (var fieldName in formChildren)
                    if (formChildren.hasOwnProperty(fieldName) && formChildren[fieldName].hasOwnProperty('errors'))
                        formFieldErrors.push({fieldName: fieldName, errors: formChildren[fieldName].errors});
                return formFieldErrors;
            }
        }
    })

    .controller('LoginCtrl', function ($scope, $http, $window, FormError) {
        $scope.submit = function () {
            $http.post( Routing.generate('fos_user_security_check', {_locale: 'de'}) , $scope.userdata)
                .success(function (data, status, headers, config) {
                    $window.sessionStorage.token = data.token;
                    // Symfony's redirect is broken due to JWT-response
                    $window.location.href = Routing.generate('barra_back_user', {_locale:'de'});
                })
                .error(function (data, status, headers, config) {
                    $scope.formErrors = FormError.selectMsg({status: status});
                    delete $window.sessionStorage.token;
                });
        };
    })
    .controller('RecipesCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        $scope.urlRecipeDetail  = Routing.generate('barra_back_recipeDetail', {_locale:'de'});

        $scope.$watch('projectId', function () {
            var route = Routing.generate('barra_api_get_recipes', {offset:0, limit:10, order_by:'name'});
            Restangular.allUrl('recipes', route).getList().then(
                function(response) {
                    $scope.recipes = response.data;
                },
                function(validationError) {
                    $scope.formErrors = FormError.selectMsg(validationError);
                }
            );
        });

        /**
         * post entry and add it to scope
         */
        $scope.submit = function() {
            //$scope.formData['position'] = $scope.sprintSteps.length+1;

            Api.post($scope.recipes, $scope.formData, 'formRecipe').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('recipes', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.recipes.push(response.data);
                            $scope.formRecipe.$setPristine(true);
                        }, function(errorMsg) {$scope.formErrors = errorMsg;}
                    );
                }, function(validationError) {
                    $scope.formErrors = FormError.selectMsg(validationError);
                    if (validationError.status == 400)
                        $scope.formFieldErrors = FormFieldError.selectMsg(validationError.data.errors.children);
                }
            );
        };

        /**
         * Delete entry server-sided and from scope
         * @param element
         */
        $scope.deleteEntry = function(element) {
            element.remove().then(
                function() {
                    $scope.recipes.splice($scope.recipes.indexOf(element), 1);
                },
                function(validationError) {
                    $scope.formErrors = FormError.selectMsg(validationError);
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
                return formField.fieldName == fieldName;
            });
        };
    })
;