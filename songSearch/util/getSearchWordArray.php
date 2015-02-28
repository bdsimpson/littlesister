<?php
require_once("explodeLevenshtein.php");

//$testPhrase = "pat beenetar";



//$searchResult = getArtistWordArray($testPhrase, true, true);



function getSearchWordArray($phrase, $levenshtein, $soundex){
    $returnArray = array();
    $phrase = strtolower($phrase);
    $phraseArray = explode(' ',$phrase);
    $dictionary = array();
    $outputArray=array();
    $foundArray = array();

    $mysqli = new mysqli('localhost','user','password','LittleSister');
    if($mysqli->connect_errno){
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
    }
    $found = false;

    if($levenshtein && !$found){

        $sqlString = "Select Word from wordlist ORDER BY Count Desc";

        if (!$result = $mysqli->query($sqlString)){
            die("There was an error getting the word list \n".$sqlString);
        }

        while($row = $result->fetch_assoc()){
            $dictionary[] = $row['Word'];
        }
        foreach($phraseArray as $word){
            $tmp = explode_levenshtein($word,$dictionary,1);
            $outputArray[$word]['levenshtein']=$tmp;
            foreach($tmp as $tmpWord){
                $foundArray[]=$tmpWord['Word'];
                if($tmpWord['Distance'] == 0){
                    $found = true;
                }
            }

        }
    }   // End of if(levenshtein)
    //**************************************************************************8

    if($soundex && !$found){
        foreach($phraseArray as $word){
            if(empty($outputArray)){
                $outputArray[$word]['soundex'][] = array('Word' => $word);
            }
            if(strlen($word) > 3){
                $sqlString = "Select Word from wordlist WHERE SOUNDEX(Word) = SOUNDEX('$word') ORDER BY Count DESC";

                if (!$result = $mysqli->query($sqlString)){
                    die("There was an error getting the soundex \n".$sqlString);
                }

                while($row = $result->fetch_assoc()){
                    if(!in_array($row['Word'],$foundArray)){
                        $outputArray[$word]['soundex'][] = array('Word' => $row['Word']);
                    }
                }
            }  // end of if strlen > 3
        }
    }   // End of if(Soundex)
    //******************************************************************************


//    echo "<pre>";
//    print_r($outputArray);
//    echo "</pre>";


    $returnArray = $outputArray;
    return $returnArray;

}
?>