<?php
require_once('../../config/db.php');
require_once('../../models/venues/venueModel.php');
require_once('../../models/venues/imageModel.php');


$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
  case 'PUT':
    //rest_put($request);  
    break;
  case 'POST':
    rest_post($request);  
    break;
  case 'GET':
    rest_get($request[0]);  
    break;
  case 'HEAD':
   // rest_head($request);  
    break;
  case 'DELETE':
    //rest_delete($request);  
    break;
  case 'OPTIONS':
    //rest_options($request);    
    break;
  default:
    //rest_error($request);  
    break;
}

function rest_get($venueID){
	$venues = new venues;
	$images = new images;
	$resultArray = Array();
	$result = $venues->getVenues($venueID);
	foreach($result as $key =>$venue){
		$venueImages =$images->getImages($venue->id);
		//var_dump($venueImages);
		
		if(is_array($venueImages)){
			$venueImage = $venueImages[0];
			$venue->venueImage = $venueImage->url;
		}else{
			$venue->venueImage = '';
		}

		$resultArray[$key] = $venue;
	}
	echo json_encode($resultArray);
}

function rest_post($venueID){
	if($venueID == '' || $venueID == NULL){
		//create

	}else{
		//update
	}
}





