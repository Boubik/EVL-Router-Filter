<?php
$configs = include('config.php');
include "functions.php";
$i = 0;
$k = 0;
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
    $insert_count = 1;
    $insert_info = "";
    $handle = fopen($filename[$i], "r");
    //Simply print them out onto the screen.
    echo $filename[$i]. "<br><br>";
    (int)$router = substr($filename[$i], 6, 4);
    (int)$rok = substr($filename[$i], 11, 4);
    (int)$mesic = substr($filename[$i], 15, 2);
    (int)$den = substr($filename[$i], 17, 2);
    (int)$id_soubor = substr($filename[$i], 19, 2);
    $date = "'".$rok. "-". $mesic. "-". $den."'";
    echo $router, $id_soubor, $date;
    if (imported($conn, $router, $id_soubor, $date) == FALSE){
        inset_imported($conn, $router, $id_soubor, $date);
        insert_time($conn, $date);
        $id_info = FALSE;
        while (($chunk = fgets($handle)) !== false){
            processFileChunk($conn, $chunk, $router, $date, $id_info);
        }
    
        fclose($handle);
    } else {
        echo 'Už je v db';
    }

    if($configs["delete_evl"] == TRUE){
        unlink($filename[$i]);
    }
    $i++;
    $last5 = "INSERT INTO `info`(`router`, `datetime`, `FW`, `prio`, `id`, `rev`, `event`, `rule`, `time_year`, `time_month`, `time_day`, `ipproto`, `ipdatalen`, `srcport`, `destport`, `tcphdrlen`, `syn`, `ece`, `cwr`, `ttl`, `ttlmin`, `udptotlen`, `ipaddr`, `iface`, `origsent`, `termsent`, `conntime`, `conn`, `action`, `badflag`, `recvif`, `srcip`, `destip`, `ipdf`) VALUES";
    $last5 = substr($last5, -5);

    if(substr($GLOBALS["insert_info"], -5) != $last5){
        to_DB($conn);
    }



}
$conn->close();
echo "<br><br>Všechno je hotové super <br><br>( •_•) <br>( •_•)>⌐■-■ <br>(⌐■_■)";

?>