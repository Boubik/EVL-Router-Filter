<?php
$configs = include('config.php');
$i = 0;
$string = "";
$fileList = glob('files/*.evl');

foreach($fileList as $filename[$i]){
    //Simply print them out onto the screen.
        echo $filename[$i]. "<br><br>";

    //$myfile = fopen($filename[$i], "r") or die("Unable to open file!");
    $lines = explode("\n", file_get_contents($filename[$i]));
    $enter = "\n";

    //$string = fgets($myfile);
    foreach ($lines as $line){

        $line = preg_replace('/[^a-zA-Z0-9-=:.[\ ]/', '', $line);
        $line = preg_replace('/\[/', $enter.'[', $line);
        $line = $line . $enter;

        $line = preg_replace('/OoD9/', '', $line);
        $line = preg_replace('/oD9/', '', $line);
        $line = preg_replace('/BD9/', '', $line);
        $line = preg_replace('/OvD9/', '', $line);
        $line = preg_replace('/OD9/', '', $line);
        $line = preg_replace('/MD9/', '', $line);
        $line = preg_replace('/D9/', '', $line);
        $line = preg_replace("/Q\n/", $enter, $line);
        $line = preg_replace('/Q7/', '', $line);
        $line = preg_replace('/W7/', '', $line);
        $line = preg_replace("/W\n/", $enter, $line);
        $line = preg_replace("/WT\n/", $enter, $line);
        $line = preg_replace("/N\n/", $enter, $line);
        $line = preg_replace("/F\n/", $enter, $line);
        $line = preg_replace("/FK3\n/", $enter, $line);
        $line = preg_replace("/K3\n/", $enter, $line);
        $line = preg_replace("/K\n/", $enter, $line);
        $line = preg_replace("/t\n/", $enter, $line);
        $line = preg_replace("/tR\n/", $enter, $line);
        $line = preg_replace("/JKA2\n/", $enter, $line);
        $line = preg_replace("/JKA\n/", $enter, $line);
        $line = preg_replace("/KA2\n/", $enter, $line);
        $line = preg_replace("/KA\n/", $enter, $line);
        $line = preg_replace("/zwE\n/", $enter, $line);
        $line = preg_replace("/z\n/", $enter, $line);
        $line = preg_replace("/WwE\n/", $enter, $line);
        $line = preg_replace("/W3AI\n/", $enter, $line);
        $line = preg_replace("/WG\n/", $enter, $line);
        $line = preg_replace("/O3AI\n/", $enter, $line);
        $line = preg_replace("/OXL\n/", $enter, $line);
        $line = preg_replace("/HXL\n/", $enter, $line);
        $line = preg_replace("/QFP\n/", $enter, $line);
        $line = preg_replace("/QP\n/", $enter, $line);
        $line = preg_replace("/QR\n/", $enter, $line);
        $line = preg_replace("/Y\n/", $enter, $line);
        $line = preg_replace("/QY\n/", $enter, $line);
        $line = preg_replace("/t\n/", $enter, $line);
        $line = preg_replace("/J\n/", $enter, $line);
        $line = preg_replace("/HFP\n/", $enter, $line);
        $line = preg_replace("/Q\n/", $enter, $line);
        $line = preg_replace("/tu\n/", $enter, $line);
        $line = preg_replace("/\[\n/", '', $line);
        $line = preg_replace("/ta\n/", $enter, $line);
        $line = preg_replace("/Ja\n/", $enter, $line);
        $line = preg_replace("/a\n/", $enter, $line);
        $line = preg_replace("/N-f\n/", $enter, $line);
        $line = preg_replace("/q3\n/", $enter, $line);
        $line = preg_replace("/N\n/", $enter, $line);
        $line = preg_replace("/q-\n/", $enter, $line);
        $line = preg_replace("/:r-\n/", $enter, $line);
        $line = preg_replace("/n\n/", $enter, $line);
        $line = preg_replace("/t\n/", $enter, $line);
        $line = preg_replace("/tn2\n/", $enter, $line);
        $line = preg_replace("/n2\n/", $enter, $line);
        $line = preg_replace("/-2\n/", $enter, $line);
        $line = preg_replace("/-\n/", $enter, $line);
        $line = preg_replace("/F\n/", $enter, $line);
        $line = preg_replace("/FZ\n/", $enter, $line);
        $line = preg_replace("/R\n/", $enter, $line);
        $line = preg_replace("/VX\n/", $enter, $line);
        $line = preg_replace("/N\n/", $enter, $line);
        $line = preg_replace("/Nb\n/", $enter, $line);
        $line = preg_replace("/t3\n/", $enter, $line);
        $line = preg_replace("/D\n/", $enter, $line);
        $line = preg_replace("/RG9\n/", $enter, $line);
        $line = preg_replace("/RG\n/", $enter, $line);
        $line = preg_replace("/O\n/", $enter, $line);
        $line = preg_replace("/NYy3\n/", $enter, $line);
        $line = preg_replace("/Yy3\n/", $enter, $line);
        $line = preg_replace("/F2\n/", $enter, $line);
        $line = preg_replace("/OA\n/", $enter, $line);
        $line = preg_replace("/ 2\n/", $enter, $line);
        $line = preg_replace("/A\n/", $enter, $line);
        $line = preg_replace("/H\n/", $enter, $line);
        $line = preg_replace("/JL5\n/", $enter, $line);
        $line = preg_replace("/JL3\n/", $enter, $line);
        $line = preg_replace("/T3\n/", $enter, $line);
        $line = preg_replace("/J:c\n/", $enter, $line);
        $line = preg_replace("/T:c\n/", $enter, $line);
        $line = preg_replace("/K:c\n/", $enter, $line);
        $line = preg_replace("/Td2\n/", $enter, $line);
        $line = preg_replace("/d2\n/", $enter, $line);
        $line = preg_replace("/d\n/", $enter, $line);
        $line = preg_replace("/y\n/", $enter, $line);
        $line = preg_replace("/yfl\n/", $enter, $line);
        $line = preg_replace("/yj\n/", $enter, $line);
        $line = preg_replace("/fl\n/", $enter, $line);
        $line = preg_replace("/l\n/", $enter, $line);
        $line = preg_replace("/H\n/", $enter, $line);
        $line = preg_replace("/Nc\n/", $enter, $line);
        $line = preg_replace("/NA\n/", $enter, $line);
        $line = preg_replace("/N\n/", $enter, $line);
        $line = preg_replace("/c\n/", $enter, $line);
        $line = preg_replace("/tR.\n/", $enter, $line);
        $line = preg_replace("/J.\n/", $enter, $line);
        $line = preg_replace("/Q.\n/", $enter, $line);
        $line = preg_replace("/D.\n/", $enter, $line);
        $line = preg_replace("/.\n/", $enter, $line);
        $line = preg_replace("/HD.\n/", $enter, $line);
        $line = preg_replace("/N3\n/", $enter, $line);
        $line = preg_replace("/x3\n/", $enter, $line);
        $line = preg_replace("/a2\n/", $enter, $line);

        $line = preg_replace("/connipproto/", "ipproto", $line);
        $line = preg_replace("/connrecvif/", "recvif", $line);
        $line = preg_replace("/conndestif/", "iface", $line);
        $line = preg_replace("/connsrcport/", "srcport", $line);
        $line = preg_replace("/conndestport/", "destport", $line);
        $line = preg_replace("/connsrcip/", "srcip", $line);
        $line = preg_replace("/conndestip/", "destip", $line);
        $line = preg_replace("/ipaddr/", "srcip", $line);


        $line = substr($line, 2);
        $line = preg_replace("/\[/", "", $line);
        
        $string = $string.$line;
        echo $line;
    }

    echo "<br>";
    file_put_contents("files/" .substr($filename[$i], 6, 15) .".txt", print_r($string, true));
    //fclose($myfile);
    if($configs["delete_evl"] == TRUE){
        unlink($filename[$i]);
    }
    $i++;
}
//echo "<br><br>";
echo "Všechno je předělané super <br><br>( •_•) <br>( •_•)>⌐■-■ <br>(⌐■_■)";
?>