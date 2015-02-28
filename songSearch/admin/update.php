<?php
require_once("session.php");

$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}
$songField = explode('_', $_POST['SongID']);
$SongID = $mysqli->real_escape_string($songField[1]);
$value= $_POST['newvalue'];
$key = $songField[0];

$sqlString = "UPDATE songlist SET $key='$value' WHERE SongID = $SongID";

//echo $songField." <BR>";
if($mysqli->query($sqlString)){
    echo "Success";
}else{
    echo "Error Updating Database";
}
?>