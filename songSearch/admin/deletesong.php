<?php
require_once("session.php");

$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}
$SongID = $mysqli->real_escape_string($_POST['SongID']);

$sqlString = "DELETE FROM songlist WHERE SongID = $SongID";

$mysqli->query($sqlString);
?>