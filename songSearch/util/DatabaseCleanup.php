<?PHP

$mysqli = new mysqli('localhost','guest','littlesister','littlesister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}

$mysqli2 = new mysqli('localhost','guest','littlesister','littlesister');
if($mysqli2->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli2->connect_errno . ") " .$mysqli2->connect_error;
}

$sqlString = "SELECT * FROM SongList";

if (!$result = $mysqli->query($sqlString)){
    die("There was an error running the search \n".$sqlString);
}


while($row = $result->fetch_assoc()){
    $cleanSongName =  preg_replace("/[^A-Za-z0-9\ ]/","", $row['SongName']);
    $cleanArtist = preg_replace("/[^A-Za-z0-9\ ]/","", $row['Artist']);
    $songID = $row['SongID'];

    $sqlString = "UPDATE SongList Set CleanSongName = '$cleanSongName', CleanArtist='$cleanArtist' WHERE SongID = $songID";
    //echo $SqlString;
        if (!$result2 = $mysqli2->query($sqlString)){
           die("There was an error running the update on song $songID \n".$sqlString);
        }
}



?>