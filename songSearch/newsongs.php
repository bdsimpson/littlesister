<?php

$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}
$rowmax = (isset($_POST['rowmax']) ? $mysqli->real_escape_string($_POST['rowmax']) : 10000);
$rowStart = (isset($_POST['start']) ? $mysqli->real_escape_string($_POST['start']) : 0);
$orderFactor = (isset($_POST['sortfactor']) ? $mysqli->real_escape_string($_POST['sortfactor']) : "Artist");

$songArray = array();

$countString = "SELECT COUNT(*) AS recordCount FROM songlist WHERE Date BETWEEN SYSDATE() - INTERVAL 60 DAY AND SYSDATE() ";

if(!$result = $mysqli->query($countString)){
    die("Error getting record count");
}
$row=$result->fetch_assoc();
$rowCount = $row['recordCount'];

if(($rowStart + $rowmax) > $rowCount){
    $rowStart = $rowCount - $rowmax;
}
if($rowStart < 0){
    $rowStart = 0;
}
$sqlString = "SELECT SongID, Artist, SongName, DATE_FORMAT(Date, '%m/%d/%y') AS Date FROM songlist WHERE Date BETWEEN SYSDATE() - INTERVAL 60 DAY AND SYSDATE() ";
$sqlString .="ORDER BY $orderFactor ";
$sqlString .="LIMIT $rowStart, $rowmax ";

//echo $sqlString;

if(!$result = $mysqli->query($sqlString)){
    die("Error getting songs from last 60 days");
}
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

            $songArray[] = $row;

    }
}else{
         $songArray[] = array('Error' => 'No Results Found');

}
$jsonString = '{"Results":'.json_encode($songArray).'}';


print_r($jsonString);

?>