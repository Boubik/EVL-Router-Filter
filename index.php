<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html" ; charset="UTF-8">
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
        $wherenable = true;
        $order[] = "";
        $orderenabler = true;
        $limit = " LIMIT 25";
        $i = 0;
        const where = 2;
        const checkbox = 3;
        const test = 0;
        include "functions.php";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            $conn = new mysqli($servername, $username, $password);
            if ($conn->connect_error) {
                if ($configs["debug_echo"] === true) {
                    die("Connection failed: " . $conn->connect_error);
                } else {
                    die("Connection to db failed: ");
                }
            } else {
                create_db();
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
                echo '<form method="POST" action="">' . "\n" . '<input type="submit" name="import_to_db"  value="Import to DB"> </form>';
                ?>
            </div>
            <div class="imported">
                <?php
                echo '<form method="POST" action="">' . "\n" . '<input type="submit" name="imported"  value="Imported in DB"> </form>';

                if (isset($_POST["import_to_db"])) {
                    exec("PHP to_db.php", $output, $return);
                    if ($return) {
                        header('Location: /to_db.php');
                    }
                }

                ?>
            </div>
        </header>
        <div class="filters">
            <?php

            if ($imported_select->num_rows > 0 and isset($_POST["imported"])) {
                echo "<br><br>";
                while ($row = $imported_select->fetch_assoc()) {
                    echo $row["router"] . "_" . $row["date"] . "_" . $row["id"];
                    echo "<br>";
                }
                echo "<br>";
            }

            $i = 0;
            while ($i != checkbox) {
                if (isset($_GET['az' . $i])) {
                    $az[$i] = $_GET['az' . $i];
                } else {
                    $az[$i] = "ASC";
                }

                if (isset($_GET['filter' . $i]) and isset($az[$i]) and $_GET['filter' . $i] != "") {
                    if ($orderenabler == true) {
                        $order[$i] = "ORDER BY ";
                        $orderenabler = false;
                    }

                    $order[$i] = $order[$i] . $_GET['filter' . $i] . " " . $az[$i];

                    if ($i + 1 < checkbox and isset($_GET['filter' . ($i + 1)]) and $_GET['filter' . ($i + 1)] != "") {
                        $order[$i] = $order[$i] . ", ";
                    }
                } else {
                    $order[$i] = "";
                }
                $i++;
            }

            if (isset($_GET['limit'])) {
                $limit = " LIMIT " . $_GET['limit'];
            } else {
                $limit = " LIMIT 25";
            }
            //filter_input()

            echo "<br><br>";


            echo    '<form action="" method="GET">
        <label>Where</label><br>';
            $i = 0;
            while ($i != where) {

                //and or uprostřed

                if ($i == 1) {
                    echo    '<select name="andor">
        <option value="and"';
                    if (isset($_GET['andor']) and $_GET['andor'] == 'and') {
                        echo "selected";
                    }

                    echo    '>and</option>
                <option value="or"';
                    if (isset($_GET['andor']) and $_GET['andor'] == 'or') {
                        echo "selected";
                    }

                    echo    '>or</option>
                </select>' . "\n";
                }



                //db where
                echo    '<select name="where' . $i . '">
            <option value="">None</option>
            <option value="info.router" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.router") {
                    echo "selected";
                }

                echo    '>Router</option>
            <option value="info.datetime" ';

                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.datetime") {
                    echo "selected";
                }

                echo    '>Date</option>
            <option value="info.FW" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.FW") {
                    echo "selected";
                }

                echo    '>Category</option>
            <option value="info.id" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.id") {
                    echo "selected";
                }

                echo    '>ID</option>
            <option value="info.rule" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.rule") {
                    echo "selected";
                }

                echo    '>Rule</option>
            <option value="info.ipproto" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.ipproto") {
                    echo "selected";
                }

                echo    '>Proto</option>
            <option value="info.recvif" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.recvif") {
                    echo "selected";
                }

                echo    '>IF Src</option>
            <option value="info.iface" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.iface") {
                    echo "selected";
                }

                echo    '>IF Dst</option>
            <option value="info.srcip" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.srcip") {
                    echo "selected";
                }

                echo    '>IP Src</option>
            <option value="info.destip" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.destip") {
                    echo "selected";
                }

                echo    '>IP Dst</option>
            <option value="info.srcport" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.srcport") {
                    echo "selected";
                }

                echo    '>Port Src</option>
            <option value="info.destport" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.destport") {
                    echo "selected";
                }

                echo    '>Port Dst</option>
            <option value="info.event" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.event") {
                    echo "selected";
                }

                echo    '>Event</option>
            <option value="info.action" ';
                if (isset($_GET['where' . $i]) and $_GET['where' . $i] == "info.action") {
                    echo "selected";
                }

                echo    '>Action</option>
            </select>' . "\n";


                //checkbox smaler of biger
                echo    '<select name="sign' . $i, '">
            <option value="="';
                if (isset($_GET['sign' . $i]) and $_GET['sign' . $i] == "=") {
                    echo "selected";
                }

                echo    '>=</option>
            <option value=">"';
                if (isset($_GET['sign' . $i]) and $_GET['sign' . $i] == ">") {
                    echo "selected";
                }

                echo    '>></option>
            <option value="<"';
                if (isset($_GET['sign' . $i]) and $_GET['sign' . $i] == "<") {
                    echo "selected";
                }

                echo    '><</option>
            <option value="!="';
                if (isset($_GET['sign' . $i]) and $_GET['sign' . $i] == "!=") {
                    echo "selected";
                }

                echo    '>!=</option>
            </select>' . "\n";



                //podmka
                echo    '<input type="text" name="textwhere' . $i . '" value="';
                if (isset($_GET['textwhere' . $i]) and $_GET['textwhere' . $i] != "") {
                    echo $_GET['textwhere' . $i];
                }
                echo    '">' . "\n";
                $i++;
            }
            echo "<br>\n";






            echo    '<br><label>Order by</label><br>';
            //checkbox sort by date...
            $i = 0;
            while ($i != checkbox) {
                echo    '<select name="filter' . $i . '">
            <option value="">none</option>';
                echo    '<option value="info.router" ';

                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.router") {
                    echo "selected";
                }

                echo    '>Router</option>
            <option value="info.datetime" ';

                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.datetime") {
                    echo "selected";
                }

                echo    '>Date</option>
            <option value="info.FW" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.FW") {
                    echo "selected";
                }

                echo    '>Category</option>
            <option value="info.id" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.id") {
                    echo "selected";
                }

                echo    '>ID</option>
            <option value="info.rule" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.rule") {
                    echo "selected";
                }

                echo    '>Rule</option>
            <option value="info.ipproto" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.ipproto") {
                    echo "selected";
                }

                echo    '>Proto</option>
            <option value="info.recvif" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.recvif") {
                    echo "selected";
                }

                echo    '>IF Src</option>
            <option value="info.iface" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.iface") {
                    echo "selected";
                }

                echo    '>IF Dst</option>
            <option value="info.srcip" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.srcip") {
                    echo "selected";
                }

                echo    '>Proto</option>
            <option value="info.destip" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.destip") {
                    echo "selected";
                }

                echo    '>IP Src</option>
            <option value="info.srcport" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.srcport") {
                    echo "selected";
                }

                echo    '>IP Dst</option>
            <option value="info.destport" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.destport") {
                    echo "selected";
                }

                echo    '>Port Src</option>
            <option value="info.event" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.event") {
                    echo "selected";
                }

                echo    '>Port Dst</option>
            <option value="info.action" ';
                if (isset($_GET['filter' . $i]) and $_GET['filter' . $i] == "info.action") {
                    echo "selected";
                }

                echo    '>Action</option>
            </select>';





                //checkbox sort by a-z...
                echo    '<select name="az' . $i, '">
            <option value="ASC"';
                if (isset($_GET['az' . $i]) and $_GET['az' . $i] == "ASC") {
                    echo "selected";
                }

                echo    '>ASC</option>
            <option value="DESC"';
                if (isset($_GET['az' . $i]) and $_GET['az' . $i] == "DESC") {
                    echo "selected";
                }

                echo    '>DESC</option>
            </select><br>';
                $i++;
            }
            ?>
            <div class="submit">
                <?php
 //limit a submit button
                echo    '<br><br>
        <label>Limit</label><br>
        <input type="text" name="limit" value="' . substr($limit, 7) . '" min="1">
        <br><br>';

                echo    '<input type="submit" name="submit" value="Submit">
        </form>';


                echo "<br><br>";


                echo "<br>\n";
                $i = 0;
                while ($i != where) {
                    if (isset($_GET['where' . $i]) and isset($_GET['textwhere' . $i]) and $_GET['where' . $i] != "" and $_GET['textwhere' . $i] != "") {
                        if ($wherenable == true) {
                            $where = "WHERE ";
                            $wherenable = false;
                        }

                        if (!(isset($configs[$_GET['textwhere' . $i]])) and $_GET['textwhere' . $i] != array_search($_GET['textwhere' . $i], $configs, true) and isset($configs[$_GET['textwhere' . $i]]) or isset($configs[array_search($_GET['textwhere' . $i], $configs, true)])) {
                            $_GET['textwhere' . $i] = array_search($_GET['textwhere' . $i], $configs, true);
                        }

                        $where = $where . $_GET['where' . $i] . ' ' . $_GET['sign' . $i] . ' "' . $_GET['textwhere' . $i] . '" ';
                        if ($i == 0 and $_GET['where' . (1)] != "" and $_GET['textwhere' . (1)] != "") {
                            $where .= ' ' . $_GET['andor'] . ' ';
                        }
                    }
                    $i++;
                }
                ?>
            </div>
        </div>
        <div class="table">
            <?php

            echo "<br><br>";

            tabulka($where, $order, $limit, checkbox);


            echo "<br><br>";
            $conn->close();
            ?>
        </div>

    </div>

    <footer>
        <div class="footer_left">
            <p>Jan Chlouba, Jakub Hájek</p>
        </div>
        <div class="footer_right">
            <p>v0.5.3&nbsp;&nbsp;&nbsp;2019</p>
        </div>
    </footer>

</body> 