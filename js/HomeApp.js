var littleSisterApp = angular.module('LittleSisterApp', ['ngRoute', 'littleSisterControllers']);



littleSisterApp.config(['$routeProvider', function($routeProvider){
   $routeProvider
        .when('/',{
            templateURL: 'partials/home.html',
            controller:  'homeController'
        })
        .otherwise({
            redirectTo: '/'
        });
}]);

