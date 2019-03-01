<?php

function imported($conn, $filename){

    (int)$router = substr($filename, 6, 4);
    (int)$rok = substr($filename, 11, 4);
    (int)$mesic = substr($filename, 15, 2);
    (int)$den = substr($filename, 17, 2);
    (int)$id_soubor = substr($filename, 19, 2);
    $date = $rok. "-". $mesic. "-". $den;
    ini_set('max_execution_time', 0);

    $sql = "SELECT * FROM imported";
    $result = $conn->query($sql);
    if ($result->num_rows> 0) {
        while($row = $result->fetch_assoc()){
            if($row["router"] == $router and $row["date"] == $date and $row["id"] == $id_soubor){
                return TRUE;
            }
        }
        return FALSE;
    }else{
        return FALSE;
    }
}

function inset_imported($conn, $filename){

    (int)$router = substr($filename, 6, 4);
    (int)$rok = substr($filename, 11, 4);
    (int)$mesic = substr($filename, 15, 2);
    (int)$den = substr($filename, 17, 2);
    (int)$id_soubor = substr($filename, 19, 2);
    $date = $rok. "-". $mesic. "-". $den;
    $date2 = '"'. $date . '"';
    ini_set('max_execution_time', 0);

    $insert_imported = "INSERT INTO `imported`(`router`, `date`, `id`) VALUES ($router, $date2, $id_soubor)";
    if($conn->query($insert_imported) === TRUE){
        echo "<br>New record created successfully insert_imported<br>";
    }
}

function insert_time($conn, $filename){

    (int)$rok = substr($filename, 11, 4);
    (int)$mesic = substr($filename, 15, 2);
    ini_set('max_execution_time', 0);

    $insert_time = "INSERT INTO `time`(`year`, `month`) VALUES ($rok, $mesic)";
    if($conn->query($insert_time) === TRUE){
        echo "<br>New record created successfully insert_time<br>";
    }
}

function to_DB($conn, $parsedLine, $router, $datetime, $FW, $rok, $mesic, $id_info){

    $configs = include('config.php');
    ini_set('max_execution_time', 0);

    $info = array("router" => "NULL", "datetime" => "NULL", "FW" => "NULL", "prio" => "NULL", "id" => "NULL", "rev" => "NULL", "event" => "NULL", "rule" => "NULL", "time_year" => "NULL", "time_month" => "NULL");
    $key = array("router", "datetime", "FW", "prio", "id", "rev", "event", "rule", "time_year", "time_month");
    $k = 0;
    while($k != 10){
        if(array_key_exists($key[$k] , $parsedLine)){
            $info[$key[$k]] = '"'.$parsedLine[$key[$k]].'"';
        }else{
            $info[$key[$k]] = '""';
        }
        $k++;
    }

    $more_info = array("ipproto" => "NULL","ipdatalen" => "NULL","srcport" => "NULL","destport" => "NULL","tcphdrlen" => "NULL","syn" => "NULL","ece" => "NULL","cwr" => "NULL","ttl" => "NULL","ttlmin" => "NULL","udptotlen" => "NULL","ipaddr" => "NULL","iface" => "NULL","origsent" => "NULL","srcport" => "NULL","termsent" => "NULL","conntime" => "NULL","conn" => "NULL","action" => "NULL","badflag" => "NULL","rule" => "NULL","recvif" => "NULL","srcip" => "NULL","destip" => "NULL","ipdf" => "NULL","info_idPrimaryKey" => "NULL",);
    $key = array("ipproto", "ipdatalen", "srcport", "destport", "tcphdrlen", "syn", "ece", "cwr", "ttl", "ttlmin", "udptotlen", "ipaddr", "iface", "origsent", "termsent", "conntime", "conn", "action", "badflag", "rule", "recvif", "srcip", "destip", "ipdf", "info_idPrimaryKey");
    $k = 0;
    while($k != 25){
        if(array_key_exists($key[$k] , $parsedLine)){
            $more_info[$key[$k]] = '"'.$parsedLine[$key[$k]].'"';
        }
        $k++;
    }

    $insert_info = "INSERT INTO `info`(`router`, `datetime`, `FW`, `prio`, `id`, `rev`, `event`, `rule`, `time_year`, `time_month`, `ipproto`, `ipdatalen`, `srcport`, `destport`, `tcphdrlen`, `syn`, `ece`, `cwr`, `ttl`, `ttlmin`, `udptotlen`, `ipaddr`, `iface`, `origsent`, `termsent`, `conntime`, `conn`, `action`, `badflag`, `recvif`, `srcip`, `destip`, `ipdf`) VALUES ($info[router], '$datetime', '$FW', $info[prio], $info[id], $info[rev], $info[event], $info[rule], $rok, $mesic, $more_info[ipproto], $more_info[ipdatalen], $more_info[srcport], $more_info[destport], $more_info[tcphdrlen], $more_info[syn], $more_info[ece], $more_info[cwr], $more_info[ttl], $more_info[ttlmin], $more_info[udptotlen], $more_info[ipaddr], $more_info[iface], $more_info[origsent], $more_info[termsent], $more_info[conntime], $more_info[conn], $more_info[action], $more_info[badflag], $more_info[recvif], $more_info[srcip], $more_info[destip], $more_info[ipdf])";    
    if($info['prio'] != '""'){

        if($configs['debug_echo'] == TRUE){
            echo $insert_info;
        }

        if($conn->query($insert_info) === TRUE){
            echo "New record created successfully insert_info<br>";

            if($id_info == FALSE){
                $id_info = id_info($conn);
            }

        }else{
            echo "něco se nepovedlo insert_info<br><br><br>";
            echo $insert_info;
        }
    }
}

function id_info($conn){

    ini_set('max_execution_time', 0);
    $sql_id = "SELECT `idPrimaryKey` FROM `info` ORDER BY `idPrimaryKey` DESC LIMIT 1";
    $id_info = $conn->query($sql_id);
    $id_info = $id_info->fetch_assoc();
    $id_info = $id_info["idPrimaryKey"];
    return $id_info;
}

function tabulka($where, $order, $limit, $checkbox){

    $configs = include('config.php');
    ini_set('max_execution_time', 0);
    $servername = $configs["servername"];
    $username = $configs["username"];
    $password = $configs["password"];
    $dbname = $configs["dbname"];
    $order2 = "";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $i = 0;
    while($i != $checkbox and isset($_GET['filter'.$i]) and $_GET['filter'.$i] != ""){
        $order2 = $order2 . ' ' . $order[$i];
        $i ++;
    }
    echo $order2;

    $select_table = "SELECT info.router, info.datetime, info.FW, info.id, info.rule, info.ipproto, info.recvif, info.iface, info.srcip, info.destip, info.srcport, info.destport, info.event, info.action FROM info $where $order2 $limit";

    if($configs['debug_echo'] == TRUE){
        echo "<br>".$select_table;
    }

    $select_table = $conn->query($select_table);
    if ($select_table->num_rows > 0) {
        // output data of each row
        echo "<div>";
        echo "<table>";
        echo "\n";
        echo "<tr><th>Router</th><th>Date</th><th>Category/ID</th><th>Rule</th><th>Proto</th><th>Src/Dst IF</th><th>Src/Dst IP</th><th>Src/dst Port</th><th>Event/Action</th></tr>";
        echo "\n";

        $i = 0;
        while($row = $select_table->fetch_assoc()) {
            if($configs["router"] == TRUE and isset($configs[$row["router"]])){
                $row["router"] = $configs[$row["router"]];
            }
            if($i%2 == 0){
                    echo "<tr><th>" . $row["router"] . "</th><th>" . $row["datetime"] . "</th><th>" . $row["FW"] . "<br>" . $row["id"] . "</th><th>" . $row["rule"] . "</th><th>" . $row["ipproto"] . "</th><th>" . $row["recvif"] . "<br>" . $row["iface"] . "</th><th>" . $row["srcip"] . "<br>" . $row["destip"] . "</th><th>" . $row["srcport"] . "<br>" . $row["destport"] . "</th><th>" . $row["event"] . "<br>" . $row["action"] . "</th></tr>";
                }else{
                    echo "<tr><th>" . $row["router"] . "</th><th>" . $row["datetime"] . "</th><th>" . $row["FW"] . "<br>" . $row["id"] . "</th><th>" . $row["rule"] . "</th><th>" . $row["ipproto"] . "</th><th>" . $row["recvif"] . "<br>" . $row["iface"] . "</th><th>" . $row["srcip"] . "<br>" . $row["destip"] . "</th><th>" . $row["srcport"] . "<br>" . $row["destport"] . "</th><th>" . $row["event"] . "<br>" . $row["action"] . "</th></tr>";
            }
            echo "\n\n";
            $i += 1;
        }
        echo "</table>";
        echo "</div>";
        echo "\n";
    } else {
        echo "<br><br>0 results";
    }

    $conn->close();
}

function create_db(){

    $configs = include('config.php');
    ini_set('max_execution_time', 0);
    $servername = $configs["servername"];
    $username = $configs["username"];
    $password = $configs["password"];
    $dbname = $configs["dbname"];
    $i = 1;

    $sql[1] = "CREATE SCHEMA IF NOT EXISTS `evl` DEFAULT CHARACTER SET utf8";

    $sql[2] = "USE evl";

    $sql[3] = "CREATE TABLE IF NOT EXISTS `evl`.`imported` (
    `router` VARCHAR(4) NOT NULL,
    `date` DATE NOT NULL,
    `id` TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (`router`, `date`, `id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8";

    $sql[4] = "CREATE TABLE IF NOT EXISTS `evl`.`time` (
    `year` YEAR(4) NOT NULL,
    `month` CHAR(2) NOT NULL,
    PRIMARY KEY (`year`, `month`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8";

    $sql[5] = "CREATE TABLE IF NOT EXISTS `evl`.`info` (
    `idPrimaryKey` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `router` VARCHAR(4) NOT NULL,
    `datetime` DATETIME NOT NULL,
    `FW` VARCHAR(45) NOT NULL,
    `prio` TINYINT UNSIGNED NOT NULL,
    `id` INT UNSIGNED NOT NULL,
    `rev` TINYINT UNSIGNED NOT NULL,
    `event` VARCHAR(45) NOT NULL,
    `rule` VARCHAR(45) NOT NULL,
    `time_year` YEAR(4) NOT NULL,
    `time_month` CHAR(2) NOT NULL,
`ipproto` VARCHAR(10) NULL,
`ipdatalen` TINYINT UNSIGNED NULL,
`srcport` SMALLINT UNSIGNED NULL,
`destport` SMALLINT UNSIGNED NULL,
`tcphdrlen` TINYINT UNSIGNED NULL,
`syn` TINYINT UNSIGNED NULL,
`ece` TINYINT UNSIGNED NULL,
`cwr` TINYINT UNSIGNED NULL,
`ttl` TINYINT UNSIGNED NULL,
`ttlmin` TINYINT UNSIGNED NULL,
`udptotlen` TINYINT UNSIGNED NULL,
`ipaddr` VARCHAR(45) NULL,
`iface` VARCHAR(45) NULL,
`origsent` SMALLINT UNSIGNED NULL,
`termsent` SMALLINT UNSIGNED NULL,
`conntime` SMALLINT UNSIGNED NULL,
`conn` VARCHAR(20) NULL,
`action` VARCHAR(45) NULL,
`badflag` VARCHAR(45) NULL,
`recvif` VARCHAR(45) NULL,
`srcip` VARCHAR(45) NULL,
`destip` VARCHAR(45) NULL,
`ipdf` TINYINT UNSIGNED NULL,
    PRIMARY KEY (`idPrimaryKey`),
    INDEX `fk_info_time1_idx` (`time_year` ASC, `time_month` ASC),
    CONSTRAINT `fk_info_time1`
        FOREIGN KEY (`time_year` , `time_month`)
        REFERENCES `evl`.`time` (`year` , `month`)
        ON DELETE CASCADE
        ON UPDATE NO ACTION)
    ENGINE = InnoDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        $conn = new mysqli($servername, $username, $password);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else{
            while($i != 6){
                if($conn->query($sql[$i]) === TRUE){
                    echo $sql[$i] . "<br>";
                }else{
                    echo "něco se nepodařilo :/<br>";
                }
                $i++;
            }
        }

    }else{
        echo "db už exituje<br>";
    }

    $conn->close();

}

function processFileChunk($conn, $chunk, $router, $rok, $mesic, $id_info){

    ini_set('max_execution_time', 0);
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

function processLine($conn, string $line, $router, $rok, $mesic, $id_info){

    ini_set('max_execution_time', 0);
    //výsledek řádku
    $parsedLine = [];

    $parsedLine["router"] = $router;


    $datetime = explode('[', $line, 1);
    $datetime = preg_replace("/ /", "-", $datetime[0]);
    $datetime = substr($datetime, 1, 19);

    $FW = explode('FW: ', $line, 2);
    $FW = explode(':', $FW[1], 2);
    $FW = $FW[0];

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