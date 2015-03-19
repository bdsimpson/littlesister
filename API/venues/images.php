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
 	if($request[0] == 'delete'){
  		if(isset($request[1])){
  			rest_delete($request[1]);
  		}else{
  			//echo false;
  		}
  	}else{
    	
    	//rest_post($request[0]);  
	}
    break;
  case 'GET':
  	//die(implode(",",$request));
    rest_get($request[0]);  
    break;
  case 'HEAD':
   // rest_head($request);  
    break;
  case 'DELETE':
    //echo "Deleting: ".$request;
    //rest_delete($request);  
    break;
  case 'OPTIONS':
    //rest_options($request);    
    break;
  default:
    //rest_error($request);  
    break;
}

function rest_get($imageID){

	$images = new images;
	$result = $images->getImages($imageID);
	
	echo json_encode($result);
}

function rest_post($imageID){
	//echo 'Well, you got to the controller with imageID = '.$imageID;
	//var_dump($_FILES);
	//var_dump($imageID);
	if(trim($imageID) == "" || $imageID == NULL){
		//create
		$file = $_FILES['file'];
		if(!save_file($file)){
			echo 'Error Saving File';
		}

		$image = new image;
		$image->url = $file['name'];

		$images = new images;
		$images->add($image);
		if(!$images->create()){
			echo 'Error Updating Database';
		}
		echo 'Image Uploaded Successfully';

	}else{
		//update
		echo 'old file: ';
		var_dump($imageID);
	}
}

function save_file($file){
	try{
		$filename = $file['name'];
		$destination = '../../images/venues/'.$filename;
		move_uploaded_file($file['tmp_name'] , $destination);
		return true;
	}catch(Exception $e){
		return false;
	}
}

function rest_delete($imageID){
	if(trim($imageID) == "" || $imageID == NULL){
		return false;
	}
	if(images::delete($imageID)){
		return true;
	}else{
		return false;
	}
}
