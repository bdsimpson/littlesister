var myApp = angular.module("LSPAdminControllers", ['angularFileUpload']);

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

    $scope.loading = false;
}]
);

myApp.controller("NewVenuesController", ['$scope', '$http', '$upload', function($scope, $http, $upload)
{
    $scope.loading=true;
    $scope.modalShown=false;
    $scope.$parent.venues=true;
    $scope.venue = {
            'id':'',
            'venueName':'',
            'venueText':'',
            'venueAddress':'',
            'venueCity':'',
            'venueState':'',
            'venueZip':'',
            'eventTime':'',
            'eventDay':'',
            'venueImage':null,

    };

    $scope.showImage = false;
    $http.get('API/venues/images.php')
        .success(function(data){
            $scope.images = data;
            //console.log(data);
            //alert('got it');
        });
    
    $scope.toggleModal=function() {
        $scope.modalShown = !$scope.modalShown;
    }


    $scope.$watch('venue.venueImage',function(){
        if($scope.venue.venueImage != null){
            $scope.showImage = true;
            console.log($scope.showImage);
        }
    });




    $scope.loading = false;
}]
);  //NewVenuesController

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

myApp.controller("ImagePickerController", ['$scope', '$http', '$upload', function($scope, $http, $upload){

    $scope.clicked = function(id){
        url = $scope.images[id].url
        $scope.$parent.venue.venueImage = url;
        $scope.$parent.showImage = true;
        //console.log($scope.$parent.venue);
        $scope.$parent.toggleModal();
    }

    $scope.deleteImage = function(id){
        image = $scope.images[id];
        console.log(image);
        
        
        $http.post('API/venues/images.php/delete/' + image.id)
            .success(function(data){
                    $http.get('API/venues/images.php')
                        .success(function(data){
                            $scope.images = data;
                            //console.log(data);
                            //alert('got it');
                        });
            });
            
    };

    $scope.$watch('files', function () {
        $scope.upload($scope.files);
        //$scope.files = {};
    });

    $scope.$watch('images', function() {
        
    })


    $scope.upload = function(files) {
        //console.log(files);
        if (files && files.length) {
            //alert('There Be Files');
            for (var i = 0; i < files.length; i++) {
                var file = files[i];

                $upload.upload({
                    url: 'API/venues/images.php',
                    file: file
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                }).success(function (data, status, headers, config) {
                    console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
                    
                    $http.get('API/venues/images.php')
                        .success(function(data){
                            $scope.files = {};
                            $scope.images=data;
                            //console.log(file);
                            url = file.name;
                            $scope.$parent.venue.venueImage = url;
                            $scope.$parent.showImage = true;
                            console.log($scope.$parent.venue);
                            $scope.$parent.toggleModal();
                            
                            //alert('got it');
                        });
                });
            }
        }
    }; // function $scope.uploadfile(files)
}]
);

myApp.directive('modalDialog', function() {
  return {
    restrict: 'E',
    scope: {
      show: '='
    },
    replace: true, // Replace with the template below
    transclude: true, // we want to insert custom content inside the directive
    link: function(scope, element, attrs) {
      scope.dialogStyle = {};
      if (attrs.width)
        scope.dialogStyle.width = attrs.width;
      if (attrs.height)
        scope.dialogStyle.height = attrs.height;
      scope.hideModal = function() {
        scope.show = false;
      };
    },
    templateUrl: 'partials/admin/imageSelectionTemplate.html'

  };
});

myApp.service('scopeService', function() {
     return {
         safeApply: function ($scope, fn) {
             var phase = $scope.$root.$$phase;
             if (phase == '$apply' || phase == '$digest') {
                 if (fn && typeof fn === 'function') {
                     fn();
                 }
             } else {
                 $scope.$apply(fn);
             }
         },
     };
});