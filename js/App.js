var LSApp = angular.module('LittleSisterApp', [
  'ngRoute',
  'LSPControllers'
]);

LSApp.config(['$routeProvider', function($routeProvider) {
  $routeProvider.
  when('/home', {
    templateUrl: 'partials/home.html',
    controller: 'HomeController'
  }).
  when('/shows', {
    templateUrl: 'partials/shows.html',
    controller:  'ShowsController'
  }).
  when('/staff', {
    templateUrl: 'partials/staff.html',
    controller:  'StaffController'
  }).
  when('/alternate', {
    templateUrl: 'partials/alternate.html',
    controller:  'AlternateController'
  }).
  otherwise({
    redirectTo: '/home'
  });
}]);