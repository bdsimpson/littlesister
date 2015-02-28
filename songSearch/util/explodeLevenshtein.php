<?php

/***************************************************************************************************
 *                                                                                                 *
 *    Explode_levenshtein... might not be the most efficient way to do this... but c'est la vis    *
 *                                                                                                 *
 **************************************************************************************************/
function explode_levenshtein($testWord,$lexiconArray,$distanceTolerance){

    require_once('levenshtein.php');
    require_once('RecordSort.php');

    $testWord = strtolower($testWord);
    //$distanceTolerance = 1;

    $outputArray = array();
    $lowestFound = $distanceTolerance;
    if(strlen($testWord) > 3){
        foreach($lexiconArray as $word){

            if ($lowestFound > 0){   // If exact match has been found, no need to continue
                //Optional --- only test words with the same beginning character
                if($word[0] == $testWord[0]){
                    $distance = LevenshteinDistance($testWord,$word);
                    if($distance < $lowestFound){
                        $lowestFound = $distance;
                    }
                    if($distance <= ($lowestFound + 1)){


                        $outputArray[] = array('Word' => $word,'Distance' => (string)$distance);
                    }else{

                    }
                }
            }
        }
    }  // end of if strlen > 3

    if(empty($outputArray)){
        $outputArray[] = array('Word' => $testWord, 'Distance' => '9999');
    }

    $filteredOutput = array();
    foreach($outputArray as $rows => $row){
        if(($row['Distance'] <= ($distanceTolerance)) || ($row['Distance'] == '9999')){
            $filteredOutput[] = array('Word' => $row['Word'],'Distance' => $row['Distance']);
        }
    }
    if(empty($filteredOutput)){
        $filteredOutput[] = array('Word' => $testWord, 'Distance' => '9999');
    }

    return record_sort($filteredOutput,"Distance");
} //End of expolde_levenshtein
/*****************************************************************************************************/

?>