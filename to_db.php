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


function processFileChunk($conn, string $chunk, $router, $rok, $mesic, $id_info)
{
    // Rozseká na nový řádky podle pole času
    $chunk = preg_replace(
        '/\[\d{4}(?:-\d{2}){2} (?:\d{2}:){2}\d{2}]/',
        "\n$0",
        $chunk
    );

    // Odstraní bordel na koncích řádků
    $chunk = preg_replace(
        '/\x00[^\x5B]*/',
        "\n",
        $chunk
    );

    // Rozdělí řádky do pole (array)
    $lines = explode("\n", $chunk);

    foreach ($lines as $line) {
        processLine($conn, $line, $router, $rok, $mesic, $id_info);
    }
}

function processLine($conn, string $line, $router, $rok, $mesic, $id_info)
{

    //výsledek řádku
    $parsedLine = [];

    $parsedLine["router"] = $router;


    $datetime = explode('[', $line, 1);
    $datetime = preg_replace("/ /", "-", $datetime[0]);
    $datetime = substr($datetime, 1, 19);
    //$parsedLine["datetime"] = $datetime;

    $FW = explode('FW: ', $line, 2);
    $FW = explode(':', $FW[1], 2);
    $FW = $FW[0];
    //$parsedLine["FW"] = $FW[0];

    //rozdělí řádek na itemy (item je ve formátu: klíč=hodnota)
    $items = explode(' ', $line);

    //pro každý item
    foreach ($items as $item) {
        //rozdělí item na pole ve formátu klíč, hodnota]
        $keyAndValue = explode('=', $item);

        //pokud má item 2 prvky (je ve formátu klíč=hodnota)
        if (count($keyAndValue) == 2) {
            //přidá klíč a hodnotu do pole výsledků
            if($keyAndValue[0] == "connipproto" or $keyAndValue[0] == "connrecvif" or $keyAndValue[0] == "conndestif" or $keyAndValue[0] == "connsrcport" or $keyAndValue[0] == "conndestport" or $keyAndValue[0] == "connsrcip" or $keyAndValue[0] == "conndestip" or $keyAndValue[0] == "ipaddr"){
                if($keyAndValue[0] == "ipaddr"){
                    $parsedLine["srcip"] = $keyAndValue[1];
                }else{
                    $parsedLine[substr($keyAndValue[0], 4)] = $keyAndValue[1];
                }
            }else{
                $parsedLine[$keyAndValue[0]] = $keyAndValue[1];
            }
        }
    }

    if (!empty($parsedLine)) {
        to_DB($conn, $parsedLine, $router, $datetime, $FW, $rok, $mesic, $id_info);
    }
}

?>