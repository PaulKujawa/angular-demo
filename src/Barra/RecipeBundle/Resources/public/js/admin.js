'use strict';

angular.module('angularApp', ['restangular', 'chart.js', 'ui.tree'])
    .config(function($interpolateProvider, $locationProvider, RestangularProvider) {
        $locationProvider.html5Mode(true);
        $interpolateProvider.startSymbol('[[').endSymbol(']]');
        RestangularProvider
            .setFullResponse(true) // to get the location header from POST responses
            .setBaseUrl(Routing.getBaseUrl() + '/en/api')
            .setDefaultHeaders({Authorization: 'Bearer ' + window.sessionStorage.token})
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
            selectMsg: function(response) {
                switch (response.status) {
                    case 400:
                        return response.data.errors.errors;
                    case 401:
                        return ['(401) Bad credentials.'];
                    case 403:
                        return ['(403) You are not authorized to access this project.'];
                    case 409:
                        return ['(409) This entry could not be deleted. Please check for dependencies.'];
                    default :
                        return ['(500) A server error occurred. Please contact the administrator for support.'];
                }
            }
        }
    })
    .factory('FormFieldError', function() {
        return {
            selectMsg: function(response) {
                var formFields  = response.data.data.children,
                    fieldErrors = [];

                for (var fieldName in formFields) {
                    if (formFields.hasOwnProperty(fieldName) && formFields[fieldName].hasOwnProperty('errors')) {
                        var errorMsg = {
                            fieldName:  fieldName,
                            errors:     formFields[fieldName].errors
                        };
                        fieldErrors.push(errorMsg);
                    }
                }

                return fieldErrors;
            }
        }
    })

    .controller('CookingCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        $scope.$watch('recipeId', function () {
            var route = Routing.generate('barra_api_get_cookings', {
                recipe: $scope.recipeId, offset:0, limit:10, order_by:'position'
            });
            Restangular.allUrl('cookings', route).getList().then(
                function(response) {
                    $scope.cookings = response.data;
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        });

        /**
         * post entry and add it to scope
         */
        $scope.submit = function() {
            Api.post($scope.cookings, $scope.formData, 'formCooking').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('cookings', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData         = null;
                            $scope.formErrors       = null;
                            $scope.formFieldErrors  = null;
                            $scope.cookings.push(response.data);
                        }, function(errorMsg) {
                            $scope.formErrors = errorMsg;
                        }
                    );
                }, function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                    if (response.status == 400) {
                        $scope.formFieldErrors = FormFieldError.selectMsg(response.data.errors.children);
                    }
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
                    var i = $scope.cookings.indexOf(element);
                    $scope.cookings.splice(i, 1);
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };


        /**
         * Triggered when new formFieldErrors were added to
         * check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName == fieldName;
            });
        };
    })
    .controller('IngredientCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        $scope.$watch('recipeId', function () {
            var route = Routing.generate('barra_api_get_ingredients', {
                recipe: $scope.recipeId, offset:0, limit:10, order_by:'position'
            });
            Restangular.allUrl('ingredients', route).getList().then(
                function(response) {
                    $scope.ingredients = response.data;
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        });

        /**
         * post entry and add it to scope
         */
        $scope.submit = function() {
            $scope.formData['recipe'] = $scope.recipeId;

            Api.post($scope.ingredients, $scope.formData, 'formIngredient').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('ingredients', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData         = null;
                            $scope.formErrors       = null;
                            $scope.formFieldErrors  = null;
                            $scope.ingredients.push(response.data);
                        }, function(errorMsg) {
                            $scope.formErrors = errorMsg;
                        }
                    );
                }, function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                    if (response.status == 400) {
                        $scope.formFieldErrors = FormFieldError.selectMsg(response.data.errors.children);
                    }
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
                    $scope.ingredients.splice($scope.ingredients.indexOf(element), 1);
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };


        /**
         * Triggered when new formFieldErrors were added to
         * check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName == fieldName;
            });
        };
    })
    .controller('LoginCtrl', function ($scope, $http, $window, FormError) {
        $scope.submit = function () {
            $http.post( Routing.generate('fos_user_security_check', {_locale: 'de'}) , $scope.userdata)
                .success(function (data, status, headers, config) {
                    $window.sessionStorage.token = data.token;
                    // Symfony's redirect is broken due to JWT-response
                    $window.location.href = Routing.generate('barra_recipe_dashboard', {_locale:'de'});
                })
                .error(function (data, status, headers, config) {
                    $scope.formErrors = FormError.selectMsg({status: status});
                    delete $window.sessionStorage.token;
                });
        };
    })
    .controller('ManufacturerCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_manufacturers', {_locale:'en', offset:0, limit:10, order_by:'name'});
        Restangular.allUrl('manufacturers', route).getList().then(
            function(response) {
                $scope.manufacturers = response.data;
            },
            function(response) {
                $scope.formErrors = FormError.selectMsg(response);
            }
        );
        //});

        /**
         * post entry and add it to scope
         */
        $scope.submit = function() {
            Api.post($scope.manufacturers, $scope.formData, 'formManufacturer').then(
                function(response) {
                    var url = response.headers('location'),
                        id  = url.substring(url.lastIndexOf('/')+1);

                    Api.get('manufacturers', id).then(
                        function(response) {
                            $scope.formData         = null;
                            $scope.formErrors       = null;
                            $scope.formFieldErrors  = null;
                            $scope.manufacturers.push(response.data);
                        }, function(errorMsg) {
                            $scope.formErrors = errorMsg;
                        }
                    );
                }, function(response) {
                    //$scope.formErrors = FormError.selectMsg(response);

                    if (response.status == 400) {
                        $scope.formFieldErrors = FormFieldError.selectMsg(response);
                    }
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
                    $scope.manufacturers.splice($scope.manufacturers.indexOf(element), 1);
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };


        /**
         * Triggered when new formFieldErrors were added to
         * check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName == fieldName;
            });
        };
    })
    .controller('MeasurementCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_measurements', {_locale:'en', offset:0, limit:10, order_by:'name'});
        Restangular.allUrl('measurements', route).getList().then(
            function(response) {
                $scope.measurements = response.data;
            },
            function(response) {
                $scope.formErrors = FormError.selectMsg(response);
            }
        );
        //});

        /**
         * post entry and add it to scope
         */
        $scope.submit = function() {
            Api.post($scope.measurements, $scope.formData, 'formMeasurement').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('measurements', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData         = null;
                            $scope.formErrors       = null;
                            $scope.formFieldErrors  = null;
                            $scope.measurements.push(response.data);
                        }, function(errorMsg) {
                            $scope.formErrors = errorMsg;
                        }
                    );
                }, function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                    if (response.status == 400) {
                        $scope.formFieldErrors = FormFieldError.selectMsg(response);
                    }
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
                    $scope.measurements.splice($scope.measurements.indexOf(element), 1);
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };


        /**
         * Triggered when new formFieldErrors were added to
         * check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName == fieldName;
            });
        };
    })
    .controller('ProductCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_products', {_locale:'en', offset:0, limit:10, order_by:'name'});
        Restangular.allUrl('products', route).getList().then(
            function(response) {
                $scope.products = response.data;
            },
            function(response) {
                $scope.formErrors = FormError.selectMsg(response);
            }
        );
        //});

        /**
         * post entry and add it to scope
         */
        $scope.submit = function() {
            Api.post($scope.products, $scope.formData, 'formProduct').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('products', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData         = null;
                            $scope.formErrors       = null;
                            $scope.formFieldErrors  = null;
                            $scope.products.push(response.data);
                        }, function(errorMsg) {
                            $scope.formErrors = errorMsg;
                        }
                    );
                }, function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                    if (response.status == 400) {
                        $scope.formFieldErrors = FormFieldError.selectMsg(response);
                    }
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
                    $scope.products.splice($scope.products.indexOf(element), 1);
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };


        /**
         * Triggered when new formFieldErrors were added to
         * check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName == fieldName;
            });
        };
    })
    .controller('RecipeCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        $scope.urlRecipe = Routing.generate('barra_recipe_recipe_admin', {_locale:'de'});

        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_recipes', {_locale:'en',offset:0, limit:10, order_by:'name'});
        Restangular.allUrl('recipes', route).getList().then(
            function(response) {
                $scope.recipes = response.data;
            },
            function(response) {
                $scope.formErrors = FormError.selectMsg(response);
            }
        );
        //}

        /**
         * post entry and add it to scope
         */
        $scope.submit = function() {
            Api.post($scope.recipes, $scope.formData, 'formRecipe').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('recipes', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData         = null;
                            $scope.formErrors       = null;
                            $scope.formFieldErrors  = null;
                            $scope.recipes.push(response.data);
                        }, function(errorMsg) {
                            $scope.formErrors = errorMsg;
                        }
                    );
                }, function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                    if (response.status == 400) {
                        $scope.formFieldErrors = FormFieldError.selectMsg(response);
                    }
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
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };


        /**
         * Triggered when new formFieldErrors were added to
         * check which form field needs to be matchy highlighted
         * @param fieldName
         * @returns {boolean}
         */
        $scope.highlightInvalidFormFields = function(fieldName) {
            return $scope.formFieldErrors.some(function(formField) {
                return formField.fieldName == fieldName;
            });
        };
    })
    .controller('PhotoCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        $scope.$watch('recipeId', function () {
            var path = '/barra/vpit/web/uploads/documents/',
                route = Routing.generate('barra_api_get_recipes_photos', {
                    recipe: $scope.recipeId, offset:0, limit:10, order_by:'name'
                })
            ; // TODO get photos, ingredients und measurements via recipe api endpoint

            Restangular.allUrl('photos', route).getList().then(
                function(response) {
                    $scope.photos = response.data; // push to angular
                    $.each($scope.photos, function(i, photo) {

                    });
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );

            // called on every successful file upload
            this.on("success", function(file, response) {
                addRemoveLink(response.id, file);
            });
        });


        /**
         * Delete entry server-sided and from scope
         * @param i
         */
        $scope.deleteEntry = function(i) {
            console.log(2);
            element.remove().then(
                function() {
                    $scope.photos.splice(i, 1);
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };
    })
;