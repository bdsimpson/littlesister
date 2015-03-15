var LSApp = angular.module('LittleSisterAdminApp', [
  'ngRoute',
  'LSPAdminControllers'
]);

LSApp.config(['$routeProvider', function($routeProvider) {
  $routeProvider.
  when('/venues', {
    templateUrl: 'partials/admin/editVenues.php',
    controller:  'VenuesController'
  }).
    when('/newvenue', {
    templateUrl: 'partials/admin/newVenue.php',
    controller:  'NewVenuesController'
  }).
  when('/staff', {
    templateUrl: 'partials/admin/editStaff.php',
    controller:  'StaffController'
  }).
  otherwise({
    redirectTo: '/'
  });
}]);