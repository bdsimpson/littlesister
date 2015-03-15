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
  when('/venues', {
    templateUrl: 'partials/venues.html',
    controller:  'VenuesController'
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