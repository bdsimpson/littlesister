var myApp = angular.module("LSPControllers", []);

myApp.controller("MainController", ['$scope', '$http', '$rootScope', function($scope, $rootScope, $http)
{



}]
);

myApp.controller("HomeController", ['$scope', '$http', function($scope, $http)
{

    $scope.$parent.home=true;

}]
);

myApp.controller("ShowsController", ['$scope', '$http', function($scope, $http)
{
    $scope.$parent.shows=true;

}]
);

myApp.controller("StaffController", ['$scope', '$http', function($scope, $http)
{
    $scope.$parent.staff=true;

}]
);

myApp.controller("AlternateController", ['$scope', '$http', function($scope, $http)
{
    $scope.$parent.alternate=true;

}]
);