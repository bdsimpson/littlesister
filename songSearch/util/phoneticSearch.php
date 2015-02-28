<?php


$mysqli = new mysqli('localhost','guest','littlesister','littlesister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}

$sqlString = "Select Distinct CleanArtist AS TestPhrase from SongList where SongID >= 30000 AND SongID < 31000";

if (!$result = $mysqli->query($sqlString)){
    die("There was an error building the Artist Lexicon \n".$sqlString);
}

$lexiconArray=array();
$lexiconMulti=array();
while($row = $result->fetch_assoc()){
    $artistValues = explode(" ",$row['TestPhrase']);
    foreach($artistValues as $word){
        $word = strtolower($word);

        if(!in_array($word,$lexiconArray)){          //If word has not been found yet
            if(strlen($word) > 3){
                $lexiconArray[] = $word;
                $lexiconMulti[] = array('Word' => $word, 'Count' => 1);
            }
        }else{                                       //Word has already been found...incriment the count
            for($i=0;$i<sizeof($lexiconMulti);$i++){
                if($lexiconMulti[$i]['Word'] == $word){
                    $lexiconMulti[$i]['Count'] += 1;
                }
            }
        }         //end of if/else
    }      //end of foreach
}   // end of while()


//echo '<pre>';
//print_r($lexiconArray);
//echo '</pre>';

//echo '<pre>';
//print_r($lexiconMulti);
//echo '</pre>';

foreach($lexiconMulti as $word){
    $sqlString = "INSERT INTO wordlist (Word,Count) ";
    $sqlString .= "VALUES ('".$word['Word']."',".$word['Count'].") ";
    $sqlString .= "ON DUPLICATE KEY UPDATE Count = Count + ".$word['Count'];

    if (!$result = $mysqli->query($sqlString)){
        die("<BR>There was an error writing the word list... $word <BR>".$mysqli->error);
    }
}
echo $sqlString;


?>