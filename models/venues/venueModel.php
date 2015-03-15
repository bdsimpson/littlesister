<?PHP

class venue {
	public $id;
	public $venueName;
	public $venueAddress;
	public $venueCity;
	public $venueState;
	public $venueZip;
	public $imageID;
	public $venueImage;
	public $venueText;
	public $eventDay;
	public $eventTime;

	private $db;

	public function __construct(){
		$this->id = '';
		$this->venueName = '';
		$this->venueAddress = '';
		$this->venueCity = '';
		$this->venueState = '';
		$this->venueZip = '';
		$this->imageID = '';
		$this->venueImage = '';
		$this->venueText = '';
		$this->eventDay = '';
		$this->eventTime = '';

		$this->db = new DB;
	}

	public function create(){
		$db = $this->db;
		$connection = new mysqli($db->host,$db->user,$db->password,$db->db);
		//check connection
		if($connection->connect_error){
			die('Connection Failed: '. $connection->connect_error);
		}

		$sqlString = 'INSERT INTO venues (venueName, venueAddress, venueCity, venueState, venueZip, imageID, venueText, eventDay, eventTime) ';
		$sqlString .= "VALUES ('$this->venueName','$this->venueAddress','$this->venueCity','$this->venueState','$this->venueZip','$this->imageID','$this->venueText','$this->eventDay', '$this->eventTime')";

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

	public function update(){
		$db = $this->db;
		$connection = new mysqli($db->host,$db->user,$db->password,$db->db);
		//check connection
		if($connection->connect_error){
			die('Connection Failed: '. $connection->connect_error);
		}

		$sqlString = "UPDATE venues SET ";
		$sqlString .= "venueName = '$this->venueName', ";
		$sqlString .= "venueAddress = '$this->venueAddress', ";
		$sqlString .= "venueCity = '$this->venueCity', ";
		$sqlString .= "venueState = '$this->venueState', ";
		$sqlString .= "venueZip = '$this->venueZip', ";
		$sqlString .= "imageID = '$this->imageID', ";
		$sqlString .= "venueText = '$this->venueText', ";
		$sqlString .= "eventDay = '$this->eventDay', ";
		$sqlString .= "eventTime = '$this->eventTime', ";
		$sqlString .= "WHERE id = $this->id";

		


		if($connection->query($sqlString) === TRUE){
			$returnValue = true;
		}else{
			$returnValue = false;
		}

		$connection->close();



		/*********************************************************
		Update Image
		***********************************************************/
		return $returnValue;

	}
		public function getImage($id){
		$images = new images;
		$imageArray = $images->getImages($id);
		if(is_array($imageArray)){
			$image = $imageArray[0];
			return $image;
		}
		return(false);
	}

}

class venues {
	private $collection;
	private $table;
	private $db;
	//private $connection;

	public function __construct(){
		$this->collection = Array();
		$this->table = 'venues';
		$this->db = new DB;

	}

	public function getVenues($id = ''){
		//Clear old data
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
			//echo '<PRE>';
			//var_dump($row);
			//echo '</PRE>';
			$venue = new venue;
			$venue->id = $row['id'];
			$venue->venueName = $row['venueName'];
			$venue->venueAddress = $row['venueAddress'];
			$venue->venueCity = $row['venueCity'];
			$venue->venueState = $row['venueState'];
			$venue->venueZip = $row['venueZip'];
			$venue->venueText = $row['venueText'];
			$venue->imageID = $row['imageID'];
			$venue->eventDay = $row['eventDay'];
			$venue->eventTime = $row['eventTime'];

			//get venueImage
			//$venueImage = images::getUrlByID($venue->imageID);

			$this->add($venue);

		}

		return($this->collection);

	}

	public function add(venue $venue){
		$this->collection[] = $venue;
	}
}	