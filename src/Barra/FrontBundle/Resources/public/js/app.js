'use strict'; // Routing.generate('barra_api_get_recipes', {_format: json}, true)
angular.module('angularApp', ['restangular'])
    .config(function(RestangularProvider) {
        RestangularProvider.setBaseUrl('/barra/vpit/web/app_dev.php/api');

        /*  local server runs at GMT yet (-1 hour)
            digest= 5000 rounds of SHA-512 hash algorithm + salted password
            xVimiBXn6KFmqv1nFHiwGUY0lfGjvcg29KtzT1u8qmnWErSDyuANGSNEU7RIAMYucDfBAJSld4UaoZ3IPLsYIw==
         */
        RestangularProvider.setDefaultHeaders({
            'X-WSSE':        'UsernameToken Username="rest", PasswordDigest="6x9Hg4lFT+fiMhbKIyClI2dXPow=", ' +
                             'Nonce="NTBmZmQ1NWUyYjU5NTkyMQ==", Created="2015-03-26T09:38:08Z"',
            'Authorization': 'WSSE profile="UsernameToken"'
        });
        RestangularProvider.setResponseExtractor(function(response, operation) {
            return response.data;
        });
    })


    .factory('MyService', function() {
        var items = [];
        return {
            getItems: function() {
                return items;
            },
            addArticle: function(article) {
                items.push(article);
            },
            sum: function() {
                return items.reduce(function(total, article) {
                    return total + article.id; // semantic nonsense
                }, 0);
            }
        };
    })

    .controller('RecipesCtrl', function($scope, $http, Restangular, MyService) {
        var baseRecipes     = Restangular.all('recipes');
        $scope.recipes      = baseRecipes.getList().$object;                    // GET list
        $scope.recipe       = Restangular.one('recipes', 4323).get().$object;   // GET one
        $scope.myService    = MyService;

        var newRecipe = {'formRecipe': {name: "angular's POST"}};               // POST one
        baseRecipes.post(newRecipe);
    })


    .controller('CartCtrl', function($scope, MyService){
        $scope.myService = MyService;
    })


    .directive('price', function(){
        return {
            restrict: 'E', // E: <price value="foo" />   A: <span price value="foo">      C: <span class="price" value="foo">
            scope: {value: '='},
            template: '<span ng-show="value == 0">kostenlos</span><span ng-show="value > 0">{{value | currency}}</span>'
        }
    });