<?php
$configs = include('config.php');
include "functions.php";
$i = 0;
$string = "";
$fileList = glob('files/*.evl');
$configs = include('config.php');
$servername = $configs["servername"];
$username = $configs["username"];
$password = $configs["password"];
$dbname = $configs["dbname"];
ini_set('max_execution_time', 0);

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

foreach($fileList as $filename[$i]){
    $handle = fopen($filename[$i], "r");
    //Simply print them out onto the screen.
    echo $filename[$i]. "<br><br>";
    (int)$router = substr($filename[$i], 6, 4);
    (int)$rok = substr($filename[$i], 11, 4);
    (int)$mesic = substr($filename[$i], 15, 2);

    $test = 0;

    if (imported($conn, $filename[$i]) == FALSE){
        inset_imported($conn, $filename[$i]);
        insert_time($conn, $filename[$i]);
        $id_info = FALSE;
        while (($chunk = fgets($handle)) !== false){
            processFileChunk($conn, $chunk, $router, $rok, $mesic, $id_info);
        }
    
        fclose($handle);
    } else {
        echo 'Už je v db';
    }

    if($configs["delete_evl"] == TRUE){
        unlink($filename[$i]);
    }
    $i++;
}
$conn->close();
echo "<br><br>Všechno je hotové super <br><br>( •_•) <br>( •_•)>⌐■-■ <br>(⌐■_■)";

?>