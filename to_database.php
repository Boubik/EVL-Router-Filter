<?php
$configs = include('config.php');
$servername = $configs["servername"];
$username = $configs["username"];
$password = $configs["password"];
$dbname = $configs["dbname"];
$i = 0;
$uz_je_v_db = false;
$fileList_prepared = glob('files/*.txt');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

foreach($fileList_prepared as $filename[$i]){
    //Simply print them out onto the screen.
    $lines = explode("\n", file_get_contents($filename[$i]));
    $filename[$i] = preg_replace('/files\/un_prepared\//', '', $filename[$i]);
    echo $filename[$i]. "<br><br>";

    (int)$router = substr($filename[$i], 6, 4);
    (int)$rok = substr($filename[$i], 11, 4);
    (int)$mesic = substr($filename[$i], 15, 2);
    (int)$den = substr($filename[$i], 17, 2);
    (int)$id_soubor = substr($filename[$i], 19, 2);
    $soubor = substr($filename[$i], 0, 15);
    $date = $rok. "-". $mesic. "-". $den;

    $date2 = '"'. $date . '"';


    /*echo "<br>" . $router;
    echo " " . $rok;
    echo " " . $mesic;
    echo " " . $den;
    echo " " . $id_soubor;
    echo "<br>" . $soubor;
    echo "<br>" . $date;*/


    $sql = "SELECT * FROM imported";
    $insert_time = "INSERT INTO `time`(`year`, `month`) VALUES ($rok, $mesic)";
    $insert_imported = "INSERT INTO `imported`(`router`, `date`, `id`) VALUES ($router, $date2, $id_soubor)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            if($row["router"] == $router and $row["date"] == $date and $row["id"] == $id_soubor){
                $uz_je_v_db = true;
            }
        }

        if($uz_je_v_db == true){
            echo "<br><br>už je v databázi ".$soubor;
        }
    }

    if($uz_je_v_db == false){
        echo "<br><br>jdeme dát do databáze ".$soubor;

    if($conn->query($insert_imported) === TRUE){
        echo "<br>New record created successfully insert_imported<br>";


        //echo "<br>".$insert_time."<br><br>";
        if($conn->query($insert_time) === TRUE){
            echo "<br>New record created successfully insert_time<br>";
        }else{
            echo "<br>něco se nepovedlo insert_time<br>";
        }
    
    echo $soubor;
    foreach ($lines as $line){
        $items = explode(' ', $line);
        $more_info = array("ipproto" => "NULL","ipdatalen" => "NULL","srcport" => "NULL","destport" => "NULL","tcphdrlen" => "NULL","syn" => "NULL","ece" => "NULL","cwr" => "NULL","ttl" => "NULL","ttlmin" => "NULL","udptotlen" => "NULL","ipaddr" => "NULL","iface" => "NULL","origsent" => "NULL","srcport" => "NULL","termsent" => "NULL","conntime" => "NULL","conn" => "NULL","action" => "NULL","badflag" => "NULL","rule" => "NULL","recvif" => "NULL","srcip" => "NULL","destip" => "NULL","ipdf" => "NULL","info_idPrimaryKey" => "NULL",);
        //echo "<br><br>";
        //echo $line."<br>";

        $datetime = '"' .$date. "-". substr($line, 11, 8). '"';
        preg_match('/: ([A-Z])+/' , $line, $matches);
        $FW = '"'.substr($matches[0], 2, strlen($matches[0])).'"';
        preg_match('/prio=\d/' , $line, $matches);
        (int)$prio = '"'.substr($matches[0], 5, strlen($matches[0])).'"';
        preg_match('/id=(\d)+/' , $line, $matches);
        (int)$id = '"'.substr($matches[0], 3, strlen($matches[0])).'"';
        preg_match('/rev=(\d)+/' , $line, $matches);
        (int)$rev = '"'.substr($matches[0], 4, strlen($matches[0])).'"';
        preg_match('/event=(\w)+/' , $line, $matches);
        $event = '"'.substr($matches[0], 6, strlen($matches[0])).'"';
        preg_match('/rule=(\w)+/' , $line, $matches);
        $rule = '"'.substr($matches[0], 5, strlen($matches[0])).'"';

        $insert_info = "INSERT INTO `info`(`router`, `datetime`, `FW`, `prio`, `id`, `rev`, `event`, `rule`, `time_year`, `time_month`) VALUES ($router, $datetime, $FW, $prio, $id, $rev, $event, $rule, $rok, $mesic)";
        //echo "<br>".$insert_info."<br><br>";
        if($FW == '""'){

        }else{

            if($conn->query($insert_info) === TRUE){
                echo "<br>New record created successfully insert_info<br>";
            }else{
                echo "<br>něco se nepovedlo insert_info<br>";
            }

            $items = explode(' ', $line);

            //výsledek řádku
            $parsedLine = [];

            //pro každý item
            foreach ($items as $item) {
                //rozdělí item na pole ve formátu klíč, hodnota]
                $keyAndValue = explode('=', $item);

                //pokud má item 2 prvky (je ve formátu klíč=hodnota)
                if (count($keyAndValue) == 2) {
                    //přidá klíč a hodnotu do pole výsledků
                    $parsedLine[$keyAndValue[0]] = $keyAndValue[1];
                }
            }

            $key = array("ipproto", "ipdatalen", "srcport", "destport", "tcphdrlen", "syn", "ece", "cwr", "ttl", "ttlmin", "udptotlen", "ipaddr", "iface", "origsent", "termsent", "conntime", "conn", "action", "badflag", "rule", "recvif", "srcip", "destip", "ipdf", "info_idPrimaryKey");
            /*$key2 = array(
                array(17,1);
                array("18","26");
                array(19,2);
                array(20,12);
                array(21,3);
            );*/
            $k = 0;
            while($k != 31){
                if(array_key_exists($key[$k] , $parsedLine)){
                    $more_info[$key[$k]] = '"'.$parsedLine[$key[$k]].'"';
                }
                $k++;
            }
            $sql_id = "SELECT `idPrimaryKey` FROM `info` ORDER BY `idPrimaryKey` DESC LIMIT 1";

            
            $id_info = $conn->query($sql_id);
            $id_info = $id_info->fetch_assoc();
            $id_info = $id_info["idPrimaryKey"];


            $insert_more_info = "INSERT INTO `more_info`(`ipproto`, `ipdatalen`, `srcport`, `destport`, `tcphdrlen`, `syn`, `ece`, `cwr`, `ttl`, `ttlmin`, `udptotlen`, `ipaddr`, `iface`, `origsent`, `termsent`, `conntime`, `conn`, `action`, `badflag`, `rule`, `recvif`, `srcip`, `destip`, `ipdf`, `info_idPrimaryKey`) VALUES ( $more_info[ipproto], $more_info[ipdatalen], $more_info[srcport], $more_info[destport], $more_info[tcphdrlen], $more_info[syn], $more_info[ece], $more_info[cwr], $more_info[ttl], $more_info[ttlmin], $more_info[udptotlen], $more_info[ipaddr], $more_info[iface], $more_info[origsent], $more_info[termsent], $more_info[conntime], $more_info[conn], $more_info[action], $more_info[badflag], $more_info[rule], $more_info[recvif], $more_info[srcip], $more_info[destip], $more_info[ipdf], $id_info)";

            //echo "<br>".$insert_more_info."<br><br>";
            if($conn->query($insert_more_info) === TRUE){
                echo "New record created successfully insert_more_info<br>";
            }else{
                echo "něco se nepovedlo insert_more_info<br>";
            }
            //}

    }
    }
    }else {
        echo "<br>Error: " . $sql . "<br>" . $conn->error;
    }
    }
    if($configs["delete_txt"] == TRUE){
        unlink($filename[$i]);
    }
    $i++;
}

echo "<br><br>Všechno je importované v db super <br><br>( •_•) <br>( •_•)>⌐■-■ <br>(⌐■_■)";
?>