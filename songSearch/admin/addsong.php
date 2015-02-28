<?php
require_once("session.php");

$mysqli = new mysqli('localhost','user','password','LittleSister');
if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .$mysqli->connect_error;
}
$rowmax = 10;
$htmlString = "";
$inputArray = array();
$msgString = "";

if(isset($_POST['numrows'])){
    $rowmax = $_POST['numrows'];
    if($rowmax < 1){
        $rowmax = 1;
    }
}
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/
foreach($_POST as $key => $value){
    $key = trim($key);
    $value = trim($value);
    if($value != "" && $key != "" && $key != "numrows" && $key != "Submit" && $key != "Change"){
        $tmp = explode("_",$key);
        if(empty($inputArray[$tmp[1]][$tmp[0]])){
            $inputArray[$tmp[1]][$tmp[0]] = $value;
        }
    }

}

if(!empty($inputArray)){

    $finalArray = array();
    $sqlSongList = "Insert IGNORE into songlist(SongName, Artist, CleanSongName, CleanArtist) VALUES ";
    $sqlWordList = "Insert INTO wordlist (word, count) VALUES ";
    $updated = 0;





    foreach($inputArray as $key => $value){
        if(isset($value['songname']) && isset($value['artist'])){
            $songName = strtoupper($value['songname']);
            $artist = strtoupper($value['artist']);

            $cleanSongName = preg_replace("/[^A-Za-z0-9\ ]/","", $songName);
            $cleanArtist = preg_replace("/[^A-Za-z0-9\ ]/","", $artist);
            $stringToAdd = "$cleanSongName $cleanArtist";
            $wordsToAdd = explode(" ",$stringToAdd);

            $songName = $mysqli->real_escape_string($songName);
            $artist = $mysqli->real_escape_string($artist);


            $sqlSongList = "INSERT IGNORE INTO songlist (SongName, Artist, CleanSongName, CleanArtist) VALUES ";
            $sqlSongList .= "('$songName','$artist','$cleanSongName','$cleanArtist')";
            if(!$mysqli->query($sqlSongList)){
                $msgString = "Error Updating Song List";
            }
            $updated = $updated + $mysqli->affected_rows;
            foreach($wordsToAdd as $word){
                $sqlWordList .="('$word','1'),";

            }
        }
    }


//    if(substr($sqlSongList,-1) == ','){
//        $sqlSongList = substr($sqlSongList,0,-1).";";
//    }
    if(substr($sqlWordList,-1) == ','){
        $sqlWordList = substr($sqlWordList,0,-1);
    }


    $sqlWordList .= " ON DUPLICATE KEY UPDATE Count = Count + 1";
    //echo "<pre>";
    //print_r($result);
    //print_r($finalArray);
    //echo "</pre>";
//    echo"<BR> $sqlSongList";
    //echo"<BR> $sqlWordList";



    $count = count($inputArray);
    //$updated = $mysqli->affected_rows;
    $ignored = $count - $updated;
    $msgString = "$updated Songs Uploaded. ($ignored Ignored as Duplicate)";

    if(!$mysqli->query($sqlWordList)){
        $msgString = "Error Updating Word List...".$mysqli->error;
    }
}

if($msgString == ""){
    $alertString = "";
}else{
    $alertString = "alert(\"$msgString\");";
}

?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
    <script src="../jquery/jquery-1.9.1.js"></script>
    <script language="javascript">
        $(document).ready(function(){
          <?PHP echo $alertString ?>
           // JQuery methods here

            $("#Menu").click(function(){
                window.location="index.php";
            });


    }); // end of (document.ready()




   </script>
    <style>
        html, body
            {
                height:100%;
                padding:0px;
                margin:0px;
            }
        body
            {
                background-image:url('../images/rose-background.jpg');
            }
        #Welcome
            {
                border-bottom:1px solid black;
                background:white;
                margin:0px;
            }
        #Welcome a
            {
                text-decoration:none;
                color:blue;
            }
        #content
            {
                width:80%;
                height:100%;
                background-image:url('../images/parchment-background.jpg');

                margin:0 auto;
                border:1px solid black;
                text-align:center;
            }
        .Button
            {
                width:120px;
                display:inline-block;
                margin-top:10px;
                height:30px;
                text-align:center;
                background:rgb(102,204,255);
                cursor:pointer;
                border:3px inset rgb(0,0,102);
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
        #insertlist
            {
                width:520px;
                margin-right:auto;
                margin-left:auto;
            }
        .evenrow input
            {
                background-color:lightcyan;

            }
        td
            {
                padding-left:0px;
                padding-right:0px;
                padding-top:0px;
                padding-bottom:0px;
                margin:0px;
                border:1px solid black;
            }
        td input
            {
                width:250px;
            }
        table
            {
                border-collapse:collapse;
            }
        table input
            {

                padding-left:2px;
            }
        .center
            {
                text-align:center;
            }

    </style>

</HEAD>


<BODY>
    <div id="Welcome">
        Welcome <? echo $_SESSION['user']; ?>. &nbsp &nbsp  <a href="logout.php">Log Out</a>
    </div>
    <div id="content">
        <div id="insertlist">
            <div class="MenuTitle">
                <H2>Little Sister Karaoke Admin</h2>
                <H3>Add New Songs</H3>
            </div>
            <form action="addsong.php" method="POST">
                <Table>
                    <Thead>
                        <TR>
                            <TH>Song Name</TH><TH>Artist</TH>
                        </TR>
                    </Thead>
                    <Tbody>
                        <?php
                        for($i=0; $i < $rowmax; $i++){
                            $htmlString .= "<TR";
                            if($i%2 == 0){
                                $htmlString .= " class=\"evenrow\"";
                            }
                            $htmlString .=">\n";
                            $htmlString .= "<TD><input type=\"text\" id=\"songname_$i\" name=\"songname_$i\"></TD><TD><input type=\"text\" id=\"artist_$i\" name=\"artist_$i\"></TD>\n";
                            $htmlString .= "</TR>\n";
                        }
                        echo $htmlString;
                        ?>
                    </Tbody>


                </Table>
                <div class="center">
                    Change Number of Rows: <input type="text" style="width:20px" id="numrows" name="numrows" value="<?php echo $rowmax; ?>"> &nbsp <input type="submit" value="Change" name="Change">
                </Div>
                <div class="center">
                    <input type = "submit" value="Submit" name="Submit">
                </div>
            </form>
            <HR>
            <div class="Button" id="Menu">
                Admin Menu
            </div>
        </div>
    </div>

</BODY>

</HTML>
