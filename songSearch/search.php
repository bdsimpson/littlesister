<?PHP
require_once('util/getSearchWordArray.php');
require_once('util/RecordSort.php');


$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}


$searchString = $_POST['SearchField'];
$searchParameter = $_POST['parameters'];

$searchString = preg_replace("/[^A-Za-z0-9\ ]/","", $searchString);

$searchString = strtolower($searchString);

$searchValues = explode(" ",$searchString);
$numSearchWords = count($searchValues);
$matchtolerance = $numSearchWords * (.9);
$exactPriority = 1;
$partialPriority = 2;

$foundArray = array();
$foundlist = "";



$ignorecount=0;

$exactResults = 0;

If($searchString == ""){    //Don't bother searching if there is not search string
    die();
}

 /******************************************************************************
  ********************************************************************************
  *        Find Exact Matches
  *******************************************************************************
  ******************************************************************************/

if($searchParameter <> "Both"){
    $sqlString =  "SELECT SongID FROM songlist WHERE ";

  /*********************************************************************************
 *   Create from conditions with exact values in song name or artist search
 ********************************************************************************/
    if($searchParameter == "SongName"){
        $sqlString .= "(LOWER(CleanSongName) Like '$searchString') ";//or SOUNDEX(CleanSongName) Like SOUNDEX('$searchString') ";

    }
    if($searchParameter == "Artist"){
        $sqlString .= "(LOWER(CleanArtist) Like '$searchString') ";//or SOUNDEX(CleanArtist) Like SOUNDEX('$searchString') ";
    }

    if (!$result = $mysqli->query($sqlString)){
        die("There was an error running the exact search \n".$sqlString);
    }

    $exactResults = $result->num_rows;

    //echo "Found $numResults results \n";

    $foundlist = "(";

    while($row = $result->fetch_assoc()){
        $foundArray[$row['SongID']] = $exactPriority;
        $foundlist .= $row['SongID'].",";
        $ignorecount += 1;
        //echo $foundlist."\n";
    }
    if($exactResults > 0) {
        $foundlist = substr($foundlist,0,-1);    // remove last comma from foundlist
    }
    $foundlist .= ")";


}else{   // end of if $parameter <> Both  BEGIN SEARCH FOR BOTH

    $sqlString =  "SELECT SongID FROM songlist WHERE ";
    $sqlString .= "LOWER(CleanArtist) Like '$searchString' ";
    $sqlString .= "OR LOWER(CleanSongName) Like '$searchString' ";
    $sqlString .= "OR LOWER(CONCAT_WS(' ',CleanArtist,CleanSongName)) like '$searchString' ";
    $sqlString .= "OR LOWER(CONCAT_WS(' ',CleanSongName,CleanArtist)) like '$searchString' ";


    if (!$result = $mysqli->query($sqlString)){
        die("There was an error running the exact search \n".$sqlString);
    }

    $exactResults = $result->num_rows;

    //echo "Found $numResults results \n";

    $foundlist = "(";



    while($row = $result->fetch_assoc()){
        $foundArray[$row['SongID']] = $exactPriority;
        $foundlist .= $row['SongID'].",";
        $ignorecount += 1;
       // echo $foundlist."\n";
    }
    if($exactResults > 0) {
        $foundlist = substr($foundlist,0,-1);    // remove last comma from foundlist
    }
    $foundlist .= ")";
    //echo $foundlist."\n";

}   // end of if $parameter <> Both
if(strlen($foundlist) == 0){
    $foundlist = "()";
}
//echo "\n$foundlist\n";
/******************************************************************************
*******************************************************************************
*   Finding Partial Matches
*******************************************************************************
******************************************************************************/
$searchArray = getSearchWordArray($searchString,true,true);
//print_r($searchArray);

$sqlString =  "SELECT SongID, CleanArtist, CleanSongName FROM songlist WHERE ";
/*********************************************************************************
 *   Create from conditions with values in song name search
 ********************************************************************************/
   if($searchParameter == "SongName"){
        $subString = "(";
        foreach ($searchArray as $wordArray){
            $subString .= "(";
            foreach($wordArray as $methodArray){
                foreach($methodArray as $word){
                    //print_r($word);
                    $subString .= "(LOWER(CleanSongName) Like '%".$word['Word']."%') + ";
                }
            }
            $subString=substr($subString,0,-2)." >=1) + ";
        }
        $subString=substr($subString,0,-2)." > $matchtolerance)";
        $sqlString .= $subString;

        if ($ignorecount > 0){
            $sqlString .= " AND SongID NOT IN $foundlist ";
        }
   }


/*********************************************************************************
 *   Create from conditions with values in Artist search
 ********************************************************************************/
   if($searchParameter == "Artist"){
        $subString = "(";
        foreach ($searchArray as $wordArray){
            $subString .= "(";
            foreach($wordArray as $methodArray){
                foreach($methodArray as $word){
                    //print_r($word);
                    $subString .= "(LOWER(CleanArtist) Like '%".$word['Word']."%') + ";
                }
            }
            $subString=substr($subString,0,-2)." >=1) + ";
        }
        $subString=substr($subString,0,-2)." > $matchtolerance)";
        $sqlString .= $subString;

        if ($ignorecount > 0){
            $sqlString .= " AND SongID NOT IN $foundlist ";
        }
   }

 /*********************************************************************************
 *   Create from conditions while searching song AND Artist
 ********************************************************************************/
    if($searchParameter == "Both"){
          $subString = "(";
            foreach ($searchArray as $wordArray){
                $subString .= "(";
                foreach($wordArray as $methodArray){
                    foreach($methodArray as $word){
                        //print_r($word);
                        $subString .= "(LOWER(CONCAT_WS(' ',CleanArtist,CleanSongName)) Like '%".$word['Word']."%') + ";
                    }
                }
                $subString=substr($subString,0,-2)." >=1) + ";
            }
            $subString=substr($subString,0,-2)." > $matchtolerance)";

            $sqlString .=$subString;

            if ($ignorecount > 0){
                $sqlString .= " AND SongID NOT IN $foundlist ";
            }




    }

   if($searchParameter == "SongName"){
        $sqlString .= " ORDER BY SongName";
   }
   $sqlString .= " Limit 150";
/*********************************************************************************
 *   END of SQL string Creation
 ********************************************************************************/

if (!$result = $mysqli->query($sqlString)){
    die("There was an error running the partial search \n".$sqlString."\n".$mysqli->errno);
}

$partialResults = $result->num_rows;



if($exactResults + $partialResults <= 150){

        if(strlen($foundlist) > 3) {
            $foundlist = substr($foundlist,0,-1).",";    // remove closing ) from foundlist, replace with ,
        }else{
            $foundlist = substr($foundlist,0,-1);
        }

    while($row = $result->fetch_assoc()){
        $assignPriority = $partialPriority;
        if(empty($foundArray[$row['SongID']])){
            if((stripos($row['CleanArtist'],$searchString) === 0) || (stripos($row['CleanSongName'],$searchString) === 0)){
                $assignPriority = 1.5;
            }
            $foundArray[$row['SongID']] = $assignPriority;
            $foundlist .= $row['SongID'].",";
        }
    }

    if(substr($foundlist,-1) == ','){
        $foundlist = substr($foundlist,0,-1).")";
    }else{
        $foundlist .= ")";
    }

}

//NEED TO SORT FOUNDARRAY

if($foundlist != "()"){     // Do not perform final search if  there are no matches

    $jsonArray = array();
    $finalSql= "Select SongName, Artist, SongID, DATE_FORMAT(Date, '%m/%d/%y') AS Date From songlist Where SongID In $foundlist";

    if (!$result = $mysqli->query($finalSql)){
        die("There was an error running the final search \n".$finalSql."\n".$mysqli->errno);
    }

    //echo $result->num_rows."\n";
    while($row = $result->fetch_assoc()){
        $priority = $foundArray[$row['SongID']];

        $jsonArray[] = array('Artist' => $row['Artist'],'SongName' => $row['SongName'],'Priority' => $priority, 'Date' => $row['Date']);
    }
    $jsonArray = record_sort($jsonArray,'Priority');

}else{
    $jsonArray[] = array('Error' => 'No Results Found');
}


$jsonString = '{"Results":'.json_encode($jsonArray).'}';

//echo $sqlString."\n";
//echo $finalSql."\n";

//print_r($jsonArray);

print_r($jsonString);

?>