<?php

class image {
	public $id;
	public $url;

	function __construct($id = '', $url = ''){
		$this->id = $id;
		$this->url = $url;

	}
}

class images {
	private $collection;
	private $table;
	private $db;

	public function __construct(){
		$this->collection = Array();
		$this->table = 'venue_images';
		$this->db = new DB;

	}

	public function getImages($id = ''){
		//Clear old Data
		$this->collection = Array();

		if($id == '' || $id == NULL){
			$sqlString = "SELECT * FROM $this->table;";
		}else{
			$sqlString = "SELECT * FROM $this->table WHERE id = $id;";
		}
		$db = $this->db;
		$connection = new mysqli($db->host,$db->user,$db->password,$db->db);

		if(!$result = $connection->query($sqlString)){
			die("There was an error looking up venues \n".$sqlString);
		}

		while($row = $result->fetch_assoc()){
			$image = new image;
			$image->id = $row['id'];
			$image->url = $row['url'];

			$this->add($image);
		}

		return($this->collection);
	}

	public function add(image $image){
		$this->collection[] = $image;
	}

	static function getUrlByID($id){
		$url = '';
		if($id == ''){ return $url;}
		$images = new images;
		$sqlString = "SELECT url FROM ".$images->table." WHERE id = $id;";
		$db = $images->db;
		$connection = new mysqli($db->host,$db->user,$db->password,$db->db);

		if(!$result = $connection->query($sqlString)){
			//die("There was an error looking up venues \n".$sqlString);
			return $url;
		}
		
		while($row = $result->fetch_assoc()){
			$url = $row['url'];
		}

		return $url;
	}

	public function create(){
		$db = $this->db;
		$connection = new mysqli($db->host,$db->user,$db->password,$db->db);
		//check connection
		if($connection->connect_error){
			die('Connection Failed: '. $connection->connect_error);
		}
		foreach($this->collection as $image)
		$sqlString = "INSERT INTO $this->table (url) ";
		$sqlString .= "VALUES ('$image->url')";

		if($connection->query($sqlString) === TRUE){
			$returnValue = true;
		}else{
			$returnValue = false;
		}

		$connection->close();

		/***************************************************
		Insert Image 
		***************************************************/


		return $returnValue;

	}

	static function delete($id = null){
		if($id == null || $id =='' || !is_numeric($id)){
			return false;
		}
		
		$images = new images;
		$sqlString = "DELETE FROM $images->table WHERE id = $id;";
		$db = $images->db;
		$connection = new mysqli($db->host,$db->user,$db->password,$db->db);
		if($connection->connect_error){
			return false;
			//die('Connection Failed: '. $connection->connect_error);
		}
		if($connection->query($sqlString) === TRUE){
			$returnValue = true;
		}else{
			$returnValue = false;
		}

		$connection->close();

		/***************************************************
		Insert Image 
		***************************************************/


		return $returnValue;
	}
}