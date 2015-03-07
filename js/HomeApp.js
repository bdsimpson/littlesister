var littleSisterApp = angular.module('myApp', ['ngRoute', 'littleSisterControllers']);



littleSisterApp.config(['$routeProvider', function($routeProvider){
   $routeProvider
        .when('/',{
            templateURL: 'home.html',
            controller:  'homeController'
        })
        .otherwise({
            redirectTo: '/'
        });
}]);

