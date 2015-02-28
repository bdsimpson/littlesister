<?PHP
require_once('levenshtein.php');
require_once('RecordSort.php');


$file = '../data/Songlexicon.csv';

$lexiconCSV = file_get_contents($file);

$lexiconArray = explode(",",$lexiconCSV);

$modifiedDate = array_shift($lexiconArray);
//echo $modifiedDate."<BR>";
//echo var_dump($lexiconArray);

$testWord = "help";

$testWord = strtolower($testWord);
$distanceTolerance = 1;

$outputArray = array();
$lowestFound = $distanceTolerance;

foreach($lexiconArray as $word){

    if ($lowestFound > 0){   // If exact match has been found, no need to continue
        //Optional --- only test words with the same beginning character
        if($word[0] == $testWord[0]){
            $distance = LevenshteinDistance($testWord,$word);
            if($distance < $lowestFound){
                $lowestFound = $distance;
            }
            if($distance <= ($lowestFound + 1)){
                //echo "$testWord ----->  $word, $distance <br>";

                $outputArray[] = array('Word' => $word,'Distance' => (string)$distance);
            }else{
               // echo "$distance! <br>";
            }
        }
    }
}

$filteredOutput = array();
foreach($outputArray as $rows => $row){
    if($row['Distance'] <= ($lowestFound + 1)){
        $filteredOutput[] = array('Word' => $row['Word'],'Distance' => $row['Distance']);
    }


}


$filteredOutput = record_sort($filteredOutput,"Distance");
$jsonString =  '{"results":'.json_encode($filteredOutput).'}';
//$jsonString = json_encode($jsonString);
echo $jsonString;

?>