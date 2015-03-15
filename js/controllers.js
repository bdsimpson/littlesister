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

myApp.controller("VenuesController", ['$scope', '$http', function($scope, $http)
{
	$scope.loading=true;
    $scope.$parent.venues=true;
    $scope.venues = {};
    $http.get('API/venues/venues.php')
    	.success(function(data){
    		$scope.venues = data;
    	});

    //$scope.loading = false;
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