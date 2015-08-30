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
            selectMsg: function(response) {
                switch (response.status) {
                    case 400:
                        return response.data.errors.errors;
                    case 401:
                        return ['(400) Bad credentials.'];
                    case 403:
                        return ['(403) You are not authorized to access this project.'];
                    case 409:
                        return ['(409) This entry could not be deleted. Please check for dependencies.'];
                    case 422:
                        return ['(422) Your new entry has a conflict. Please check for duplicates.'];
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

    .controller('AgencyCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_agencies', {offset:0, limit:10, order_by:'name'});
        Restangular.allUrl('agencies', route).getList().then(
            function(response) {
                $scope.agencies = response.data;
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
            Api.post($scope.agencies, $scope.formData, 'formAgency').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('agencies', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.agencies.push(response.data);
                            $scope.formAgency.$setPristine(true);
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
                    $scope.agencies.splice($scope.agencies.indexOf(element), 1);
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
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.cookings.push(response.data);
                            $scope.formCooking.$setPristine(true);
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
                    $scope.cookings.splice($scope.cookings.indexOf(element), 1);
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
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.ingredients.push(response.data);
                            $scope.formIngredient.$setPristine(true);
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
                    $window.location.href = Routing.generate('barra_back_user', {_locale:'de'});
                })
                .error(function (data, status, headers, config) {
                    $scope.formErrors = FormError.selectMsg({status: status});
                    delete $window.sessionStorage.token;
                });
        };
    })
    .controller('ManufacturerCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_manufacturers', {offset:0, limit:10, order_by:'name'});
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
                    var url = response.headers('location');
                    Api.get('manufacturers', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.manufacturers.push(response.data);
                            $scope.formManufacturer.$setPristine(true);
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
        var route = Routing.generate('barra_api_get_measurements', {offset:0, limit:10, order_by:'name'});
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
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.measurements.push(response.data);
                            $scope.formMeasurement.$setPristine(true);
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
        var route = Routing.generate('barra_api_get_products', {offset:0, limit:10, order_by:'name'});
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
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.products.push(response.data);
                            $scope.formProduct.$setPristine(true);
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
        $scope.urlRecipeDetail = Routing.generate('barra_back_recipeDetail', {_locale:'de'});

        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_recipes', {offset:0, limit:10, order_by:'name'});
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
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.recipes.push(response.data);
                            $scope.formRecipe.$setPristine(true);
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
    .controller('ReferenceCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        //$scope.$watch('projectId', function () {
        //$scope.urlPictures = Routing.generate('barra_back_photo', {_locale:'de'});

        var route = Routing.generate('barra_api_get_references', {offset:0, limit:10, order_by:'url'});
        Restangular.allUrl('references', route).getList().then(
            function(response) {
                $scope.references = response.data;
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
            Api.post($scope.references, $scope.formData, 'formReference').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('references', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.references.push(response.data);
                            $scope.formReference.$setPristine(true);
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
                    $scope.references.splice($scope.references.indexOf(element), 1);
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
    .controller('TechniqueCtrl', function($scope, $http, Restangular, FormError, FormFieldError, Api) {
        //$scope.$watch('projectId', function () {
        var route = Routing.generate('barra_api_get_techniques', {offset:0, limit:10, order_by:'name'});
        Restangular.allUrl('techniques', route).getList().then(
            function(response) {
                $scope.techniques = response.data;
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
            Api.post($scope.techniques, $scope.formData, 'formTechnique').then(
                function(response) {
                    var url = response.headers('location');
                    Api.get('techniques', url.substring(url.lastIndexOf('/')+1)).then(
                        function(response) {
                            $scope.formData     = null;
                            $scope.formErrors   = null;
                            $scope.techniques.push(response.data);
                            $scope.formTechnique.$setPristine(true);
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
                    $scope.techniques.splice($scope.techniques.indexOf(element), 1);
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
            var templatePanel =
                '<div class="dz-preview dz-file-preview">'              +
                '<div class="dz-details">'                              +
                '<img data-dz-thumbnail />'                             +
                '<div class="dz-filename">'                             +
                '<span data-dz-name></span>'                            +
                '</div>'                                                +
                '</div>'                                                +
                '<div class="dz-progress">'                             +
                '<span class="dz-upload" data-dz-uploadprogress></span>'+
                '</div>'                                                +
                '<div class="dz-size" data-dz-size></div>'              +
                    /*'<a class="dz-remove" href="#" data-dz-remove>'   +
                     '<span class="glyphicon glyphicon-minus"></span>'  +
                     '</a>'                                             +*/
                '<div class="dz-success-mark">'                         +
                '<span>✔</span>'                                        +
                '</div>'                                                +
                '<div class="dz-error-mark">'                           +
                '<span>✘</span>'                                        +
                '</div>'                                                +
                '<div class="dz-error-message">'                        +
                '<span data-dz-errormessage></span>'                    +
                '</div>'                                                +
                '</div>',

                templateButton =
                '<a class="dz-remove inactiveLink" href="#" data-dz-remove>'    +
                    '<span class="glyphicon glyphicon-minus"></span>'           +
                '</a>'
            ;


            Dropzone.options.dropzoneId = {
                parallelUploads:    3,
                maxFilesize:        2,          // MB, according to server & DB validation (& php.ini setting)
                thumbnailWidth:     null,       // height:100%, width:auto (100)
                acceptedFiles:      "image/*",
                previewTemplate:    templatePanel,

                init: function() {
                    var dropZone = this,
                        route = Routing.generate('barra_api_get_photos', {
                            recipe: $scope.recipeId, offset:0, limit:10, order_by:'name'
                        })
                    ;
                    Restangular.allUrl('photos', route).getList().then(
                        function(response) {
                            $scope.photos = response.data;

                            $.each($scope.photos, function(index, photo) {
                                dropZone.options.addedfile.call(dropZone, photo);
                                dropZone.options.thumbnail.call(
                                    dropZone,
                                    photo,
                                    '/barra/vpit/web/uploads/documents/' + photo.filename
                                );
                                var icon = Dropzone.createElement(templateButton);
                                photo.previewElement.appendChild(icon);
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
                }
            };
        });


        /**
         * Delete entry server-sided and from scope
         * @param element
         */
        $scope.deleteEntry = function(element) {
            element.remove().then(
                function() {
                    $scope.photos.splice($scope.photos.indexOf(element), 1);
                },
                function(response) {
                    $scope.formErrors = FormError.selectMsg(response);
                }
            );
        };
    })
;