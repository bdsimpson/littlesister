<?PHP


$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}

$query = $_POST['query'];
$query = strtolower($query);
$query = explode("-",$query);
$searchString = $query[1];
$searchParameter = $query[0];

  //echo $searchParameter;



$jsonArray = array();
$finalSql= "Select SongName, Artist, SongID From songlist Where ";

if($searchParameter == "artist"){
    if($searchString == "#"){
        $finalSql .= "Lower(Artist)  not regexp '^[a-z]' ";
    }else{
        $finalSql .= "LOWER(Artist) Like '".$searchString."%' ";
    }

    $finalSql .= "ORDER BY Artist";
}else{
    if($searchString == "#"){
        $finalSql .= "Lower(SongName) not regexp '^[a-z]' ";
    }else{
        $finalSql .= "LOWER(SongName) LIKE '".$searchString."%'";
    }

    $finalSql .= "ORDER BY SongName";
}

if (!$result = $mysqli->query($finalSql)){
    die("There was an error running the final search \n".$finalSql."\n".$mysqli->errno);
}

//echo $result->num_rows."\n";
while($row = $result->fetch_assoc()){


    $jsonArray[] = array('Artist' => $row['Artist'],'SongName' => $row['SongName']);
}



$jsonString = '{"Results":'.json_encode($jsonArray).'}';

//echo $sqlString."\n";
//echo $finalSql."\n";

//print_r($jsonArray);

print_r($jsonString);

?>