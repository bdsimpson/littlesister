<!doctype html>
<html ng-app="LittleSisterAdminApp" ng-controller="MainController">

<head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LSP Admin</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/bootstrap-3.3.2-dist/css/bootstrap.min.css">

    <!-- Optional theme -->
        <link rel="stylesheet" href="bootstrap/bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="bootstrap/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>

        <!-- Google font for Logo -->
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> <!-- load fontawesome -->


    <!-- AngularJS -->
    <script src="lib/Angular/angular.min.js" type="text/javascript" ></script>
    <script src="lib/Angular/angular-route.min.js"></script>
    <script src="js/plugins/ng-file-upload/angular-file-upload-shim.min.js"></script> <!-- file uploader -->
    <script src="js/plugins/ng-file-upload/angular-file-upload.min.js"></script> <!-- file uploader -->
    <script src="js/adminApp.js"></script> <!-- load our application -->
    <script src="js/adminControllers.js"></script> <!-- load our controller -->

    <style>
        .AdminOption {
                width:200px;
                margin-bottom:10px;

        }

        .lobster {
        font-family:Lobster;
        font-weight:bold;
        color:#A62A23;
        }
        .ng-modal-overlay {
          /* A dark translucent div that covers the whole screen */
          position:absolute;
          z-index:9999;
          top:0;
          left:0;
          width:100%;
          height:100%;
          background-color:#000000;
          opacity: 0.8;
        }
        .ng-modal-dialog {
          /* A centered div above the overlay with a box shadow. */
          z-index:10000;
          position: absolute;
          width: 50%; /* Default */
          min-height:500px;
          overflow:scroll;

          /* Center the dialog */
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          -webkit-transform: translate(-50%, -50%);
          -moz-transform: translate(-50%, -50%);

          background-color: #fff;
          box-shadow: 4px 4px 80px #000;
        }
        .ng-modal-dialog-content {
          padding:10px;
          text-align: left;
        }
        .ng-modal-close {
          position: absolute;
          top: 3px;
          right: 5px;
          padding: 5px;
          cursor: pointer;
          font-size: 120%;
          display: inline-block;
          font-weight: bold;
          font-family: 'arial', 'sans-serif';
        }
    </style>

</head>
<body>
<div class="container">
    <h1>Admin Menu</h1>
    <hr>

    <ul class="list-unstyled">
        <li>
            <a href="#/venues"><button type="button" class="btn btn-success btn-lg AdminOption">Edit Venue List</button></a>
        </li>
        <li>
            <a href="#/newvenue"><button type="button" class="btn btn-success btn-lg AdminOption">Add New Venue</button></a>
        </li>
        <li>
            <a href="#/staff"><button type="button" class="btn btn-success btn-lg AdminOption">Edit DJ List</button></a>
        </li>
    </ul>
</div>

<div class="container" ng-view>

</div>
</body>

</html>
