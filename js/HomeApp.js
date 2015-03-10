

var littleSisterApp = angular.module('LittleSisterApp', [
  'ngRoute',
  'LittleSisterControllers'
]);

GuitarApp.config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/home', {
        templateUrl: 'partials/home.html',
        controller: 'homeController'
      }).
      otherwise({
        redirectTo: '/home'
  });
}]);