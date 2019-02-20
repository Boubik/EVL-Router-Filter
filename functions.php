<?php

function tabulka($where, $order, $limit, $checkbox){
    $configs = include('config.php');
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

    $select_table = "SELECT info.datetime, info.FW, info.id, info.rule, more_info.ipproto, more_info.recvif, more_info.iface, more_info.srcip, more_info.destip, more_info.srcport, more_info.destport, info.event, more_info.action FROM info, more_info WHERE info.idPrimaryKey = more_info.info_idPrimaryKey $where $order2 $limit";
    //echo $select_table;
    $select_table = $conn->query($select_table);
    if ($select_table->num_rows > 0) {
        // output data of each row
        echo "<div id='data'>";
        echo "<table>";
        echo "\n";
        echo "<tr><th class='gray'>Date</th><th class='gray'>Category/ID</th><th class='gray'>Rule</th><th class='gray'>Proto</th><th class='gray'>Src/Dst IF</th><th class='gray'>Src/Dst IP</th><th class='gray'>Src/dst Port</th><th class='gray'>Event/Action</th></tr>";
        echo "\n";

        $i = 0;
        while($row = $select_table->fetch_assoc()) {
            if($i%2 == 0){
                    echo "<tr><th class='white'>" . $row["datetime"] . "</th><th class='white'>" . $row["FW"] . "<br>" . $row["id"] . "</th><th class='white'>" . $row["rule"] . "</th><th class='white'>" . $row["ipproto"] . "</th><th class='white'>" . $row["recvif"] . "<br>" . $row["iface"] . "</th><th class='white'>" . $row["srcip"] . "<br>" . $row["destip"] . "</th><th class='white'>" . $row["srcport"] . "<br>" . $row["destport"] . "</th><th class='white'>" . $row["event"] . "<br>" . $row["action"] . "</th></tr>";
                }else{
                    echo "<tr><th class='gray'>" . $row["datetime"] . "</th><th class='gray'>" . $row["FW"] . "<br>" . $row["id"] . "</th><th class='gray'>" . $row["rule"] . "</th><th class='gray'>" . $row["ipproto"] . "</th><th class='gray'>" . $row["recvif"] . "<br>" . $row["iface"] . "</th><th class='gray'>" . $row["srcip"] . "<br>" . $row["destip"] . "</th><th class='gray'>" . $row["srcport"] . "<br>" . $row["destport"] . "</th><th class='gray'>" . $row["event"] . "<br>" . $row["action"] . "</th></tr>";
            }
            echo "\n\n";
            $i += 1;
        }
        echo "</table>";
        echo "</div>";
        echo "\n";
    } else {
        echo "0 results";
    }
}

?>