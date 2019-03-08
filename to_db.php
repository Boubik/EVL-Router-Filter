<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html" ; charset="UTF-8">
    <link href="styles/index.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/logo.ico">
    <title>EVL Router Filter</title>
</head>
<body onload="window.open('', '_self', '');">
<?php

$configs = include('config.php');
include "functions.php";
$i = 0;
$k = 0;
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

foreach ($fileList as $filename) {
    $insert_count = 1;
    $insert_info = "";
    $log = "";
    $save = false;
    $handle = fopen($filename, "r");
    //Simply print them out onto the screen.
    if ($configs["log_print"] == true) {
        $log .= $filename . "\n\n";
    }
    if ($configs["dialog_echo"] == true) {
        echo $filename . "<br><br>";
    }
    (int)$router = substr($filename, 6, 4);
    (int)$rok = substr($filename, 11, 4);
    (int)$mesic = substr($filename, 15, 2);
    (int)$den = substr($filename, 17, 2);
    (int)$id_soubor = substr($filename, 19, 2);
    $date = "'" . $rok . "-" . $mesic . "-" . $den . "'";
    if (imported($conn, $router, $id_soubor, $date) == false) {
        inset_imported($conn, $router, $id_soubor, $date);
        insert_time($conn, $date);
        $id_info = false;
        while (($chunk = fgets($handle)) !== false) {
            processFileChunk($conn, $chunk, $router, $date, $id_info);
        }

        $last5 = "INSERT INTO `info`(`router`, `datetime`, `FW`, `prio`, `id`, `rev`, `event`, `rule`, `time_year`, `time_month`, `time_day`, `ipproto`, `ipdatalen`, `srcport`, `destport`, `tcphdrlen`, `syn`, `ece`, `cwr`, `ttl`, `ttlmin`, `udptotlen`, `ipaddr`, `iface`, `origsent`, `termsent`, `conntime`, `conn`, `action`, `badflag`, `recvif`, `srcip`, `destip`, `ipdf`) VALUES";
        $last5 = substr($last5, -5);

        if (substr($GLOBALS["insert_info"], -5) != $last5) {
            to_DB($conn);
        }
        fclose($handle);
        $log .= "\n\n";
    } else {
        if ($configs["log_print"] == true) {
            $log .= "alredy in db\n\n";
        }
        if ($configs["dialog_echo"] == true) {
            echo 'alredy in db';
        }
        $log .= $filename . "\n\n";
    }

    if ($configs["delete_evl"] == true) {
        unlink($filename);
    }
    $i++;



    save_log($filename, $log, $save);
}
$conn->close();
if ($configs["dialog_echo"] == true) {
    echo "<br><br>Všechno je hotové super <br><br>( •_•) <br>( •_•)>⌐■-■ <br>(⌐■_■)";
}

if($configs["redirect"] == TRUE){
    header('Location: /');
}