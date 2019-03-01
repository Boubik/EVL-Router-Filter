<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link href="styles/index.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/logo.ico">
    <title>EVL Router Filter</title>
</head>

<body>

<div class="wrapper">

<?php 
$configs = include('config.php');
$servername = $configs["servername"];
$username = $configs["username"];
$password = $configs["password"];
$dbname = $configs["dbname"];
ini_set('max_execution_time', 0);
$where = "";
$wherenable = TRUE;
$kde[] = "";
$textkde[] = "";
$order[] = "";
$orderenabler = TRUE;
$limit = " LIMIT 25";
$i = 0;
const where = 2;
const checkbox = 3;
include "functions.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error. "<br><br><br><br><br><br><br>DB nejde");
    }else{
        create_db();
        header("Refresh:0");
    }
}
$conn = new mysqli($servername, $username, $password, $dbname);
?>
<header>
    <div class="logo">
        <a href="index.php"><img src="images/logo.png" alt="logo"></a>
    </div>
    <div class="import">
<?php
$imported_select = "SELECT `router`, `date`, `id` FROM `imported` ORDER BY date DESC, id ASC";
$imported_select = $conn->query($imported_select);
echo '<form method="POST" action="">'."\n".'<input type="submit" name="import_to_db"  value="Import to DB"> </form>';
?>
</div>
<div class="imported">
<?php
echo '<form method="POST" action="">'."\n".'<input type="submit" name="imported"  value="Imported in DB"> </form>';

if(isset($_POST["import_to_db"])){
   exec("PHP to_db.php");
}

?>
</div>
</header>
<div class="filters">
<?php

if ($imported_select->num_rows > 0 and isset($_POST["imported"])) {
    echo "<br><br>";
    while($row = $imported_select->fetch_assoc()){
        echo $row["router"]."_".$row["date"]."_".$row["id"];
        echo "<br>";
    }
    echo "<br>";
}

$i = 0;
while($i != checkbox){
    if(isset($_GET['az'.$i])){
        $az[$i] = $_GET['az'.$i];
    }else{
        $az[$i] = "ASC";
    }

    if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] != ""){
        if($orderenabler == TRUE){
            $order[$i] = "ORDER BY ";
            $orderenabler = FALSE;
        }

        $order[$i] = $order[$i] . $_GET['filter'.$i] . " " . $az[$i];
        
        if($i+1 < checkbox and isset($_GET['filter'.($i+1)]) and $_GET['filter'.($i+1)] != ""){
            $order[$i] = $order[$i] . ", ";
        }
    }else{
        $order[$i] = "";
    }
    $i ++;
}

if(isset($_GET['limit'])){
    $limit = " LIMIT " . $_GET['limit'];
}else{
    $limit = " LIMIT 25";
}
//filter_input()

echo "<br><br>";


echo    '<form action="" method="GET">
        <label>Where</label><br>';
$i = 0;
while($i != where){

    //and or uprostřed
    
    if($i == 1){
        echo    '<select name="andor">
        <option value="and"';
        if(isset($_GET['andor']) and $_GET['andor'] == 'and'){
            echo "selected";
        }

        echo    '>and</option>
                <option value="or"';
                if(isset($_GET['andor']) and $_GET['andor'] == 'or'){
                    echo "selected";
                }

        echo    '>or</option>
                </select>' . "\n";
    }
   


    //db kde
    echo    '<select name="kde'. $i .'">
            <option value="">none</option>
            <option value="info.router" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.router"){
                echo "selected";
            }

    echo    '>router</option>
            <option value="info.datetime" ';

            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.datetime"){
                echo "selected";
            }

    echo    '>Date</option>
            <option value="info.FW" '; 
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.FW"){
                echo "selected";
            }

    echo    '>Category</option>
            <option value="info.id" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.id"){
                echo "selected";
            }

    echo    '>ID</option>
            <option value="info.rule" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.rule"){
                echo "selected";
            }

    echo    '>Rule</option>
            <option value="info.ipproto" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.ipproto"){
                echo "selected";
            }

    echo    '>Proto</option>
            <option value="info.recvif" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.recvif"){
                echo "selected";
            }

    echo    '>IF Src</option>
            <option value="info.iface" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.iface"){
                echo "selected";
            }

    echo    '>IF Dst</option>
            <option value="info.srcip" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.srcip"){
                echo "selected";
            }

    echo    '>Proto</option>
            <option value="info.destip" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.destip"){
                echo "selected";
            }

    echo    '>IP Src</option>
            <option value="info.srcport" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.srcport"){
                echo "selected";
            }

    echo    '>IP Dst</option>
            <option value="info.destport" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.destport"){
                echo "selected";
            }

    echo    '>Port Src</option>
            <option value="info.event" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.event"){
                echo "selected";
            }

            echo    '>Port Dst</option>
            <option value="info.action" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.action"){
                echo "selected";
            }

    echo    '>Action</option>
            </select>' . "\n";


    //checkbox rovno větší menší
    echo    '<select name="znaminko'.$i,'">
            <option value="="';
            if(isset($_GET['znaminko'.$i]) and $_GET['znaminko'.$i] == "="){
                echo "selected";
            }

    echo    '>=</option>
            <option value=">"';
            if(isset($_GET['znaminko'.$i]) and $_GET['znaminko'.$i] == ">"){
                echo "selected";
            }

    echo    '>></option>
            <option value="<"';
            if(isset($_GET['znaminko'.$i]) and $_GET['znaminko'.$i] == "<"){
                echo "selected";
            }

    echo    '><</option>
            <option value="!="';
            if(isset($_GET['znaminko'.$i]) and $_GET['znaminko'.$i] == "!="){
                echo "selected";
            }

    echo    '>!=</option>
            </select>' . "\n";



    //podmka
    echo    '<input type="text" name="textkde'.$i.'" value="'; 
    if(isset($_GET['textkde'.$i]) and $_GET['textkde'.$i] != ""){
        echo $_GET['textkde'.$i];
    }
    echo    '">'. "\n";
    $i ++;
}
echo "<br>\n";






echo    '<br><label>Order by</label><br>';
//checkbox sort by date...
$i = 0;
while($i != checkbox){
    echo    '<select name="filter'. $i .'">
            <option value="">none</option>';
    echo    '<option value="info.router" ';

            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.router"){
                echo "selected";
            }

    echo    '>Router</option>
            <option value="info.datetime" ';

            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.datetime"){
                echo "selected";
            }

    echo    '>Date</option>
            <option value="info.FW" '; 
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.FW"){
                echo "selected";
            }

    echo    '>Category</option>
            <option value="info.id" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.id"){
                echo "selected";
            }

    echo    '>ID</option>
            <option value="info.rule" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.rule"){
                echo "selected";
            }

    echo    '>Rule</option>
            <option value="info.ipproto" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.ipproto"){
                echo "selected";
            }

    echo    '>Proto</option>
            <option value="info.recvif" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.recvif"){
                echo "selected";
            }

    echo    '>IF Src</option>
            <option value="info.iface" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.iface"){
                echo "selected";
            }

    echo    '>IF Dst</option>
            <option value="info.srcip" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.srcip"){
                echo "selected";
            }

    echo    '>Proto</option>
            <option value="info.destip" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.destip"){
                echo "selected";
            }

    echo    '>IP Src</option>
            <option value="info.srcport" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.srcport"){
                echo "selected";
            }

    echo    '>IP Dst</option>
            <option value="info.destport" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.destport"){
                echo "selected";
            }

    echo    '>Port Src</option>
            <option value="info.event" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.event"){
                echo "selected";
            }

    echo    '>Port Dst</option>
            <option value="info.action" ';
            if(isset($_GET['filter'.$i]) and $_GET['filter'.$i] == "info.action"){
                echo "selected";
            }

    echo    '>Action</option>
            </select>';





    //checkbox sort by a-z...
    echo    '<select name="az'.$i,'">
            <option value="ASC"';
            if(isset($_GET['az'.$i]) and $_GET['az'.$i] == "ASC"){
                echo "selected";
            }

    echo    '>ASC</option>
            <option value="DESC"';
            if(isset($_GET['az'.$i]) and $_GET['az'.$i] == "DESC"){
                echo "selected";
            }

    echo    '>DESC</option>
            </select><br>';
    $i ++;
}
?>
<div class="submit">
<?php
//limit a submit button
echo    '<br><br>
        <label>Limit</label><br>
        <input type="text" name="limit" value="'. substr($limit, 7) .'" min="1">
        <br><br>';

echo    '<input type="submit" name="submit" value="Submit">
        </form>';


echo "<br><br>";


echo "<br>\n";
$i = 0;
while($i != where){
    if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] != "" and $_GET['textkde'.$i] != ""){
        if($wherenable == TRUE){
            $where = "WHERE ";
            $wherenable = FALSE;
        }

        /*if($configs["router"] == TRUE and array_keys($configs, $_GET['kde'.$i]) and $_GET['kde'.$i] == "Mariánská"){
            $key = array_keys($configs, $_GET['kde'.$i]);
            $_GET['kde'.$i] = $configs[$key[2]];
            echo "<br>".$key[0]."<br>";
        }*/


        $where = $where .$_GET['kde'.$i] . ' ' . $_GET['znaminko'.$i] . ' "' . $_GET['textkde'.$i] . '" ';
        if($i == 0 and $_GET['kde'.(1)] != "" and $_GET['textkde'.(1)] != ""){
            $where = $where . ' ' . $_GET['andor'] . ' ';
        }
    }
$i ++;
}
?>
</div>
</div>
<div class="table">
<?php

echo "<br><br>";

tabulka($where, $order, $limit, checkbox);


echo "<br><br>";
?>
</div>

</div>

<footer>
    <div class="footer_left">
        <p>Jan Chlouba, Jakub Hájek</p>
    </div>
    <div class="footer_right">
        <p>2019</p>
    </div>
</footer>

</body>