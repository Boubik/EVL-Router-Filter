<?php
const checkbox = 2;
$kde[] = "";

if(isset($_POST['kde'])){
    $kde = $_POST['kde'];
}else{
    $kde = "";
}

if(isset($_POST['znaminko'])){
    $znaminko = $_POST['znaminko'];
}else{
    $znaminko = "=";
}

//checkbox sort by date...
echo    '<form action="" method="GET">
        <label>Kde platí</label><br>';

$i = 0;
while($i != checkbox){

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
            <option value="">ničeho</option>
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
            <option value="more_info.ipproto" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "info.ipproto"){
                echo "selected";
            }

    echo    '>Proto</option>
            <option value="more_info.recvif" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.recvif"){
                echo "selected";
            }

    echo    '>IF Src</option>
            <option value="more_info.iface" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.iface"){
                echo "selected";
            }

    echo    '>IF Dst</option>
            <option value="more_info.srcip" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.srcip"){
                echo "selected";
            }

    echo    '>Proto</option>
            <option value="more_info.destip" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.destip"){
                echo "selected";
            }

    echo    '>IP Src</option>
            <option value="more_info.srcport" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.srcport"){
                echo "selected";
            }

    echo    '>IP Dst</option>
            <option value="more_info.destport" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.destport"){
                echo "selected";
            }

    echo    '>Port Src</option>
            <option value="info.event" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.event"){
                echo "selected";
            }

    echo    '>Port Dst</option>
            <option value="more_info.action" ';
            if(isset($_GET['kde'.$i]) and $_GET['kde'.$i] == "more_info.action"){
                echo "selected";
            }

    echo    '>Action</option>
            </select>';


    //checkbox rovno větší menší
    echo    '<select name="znaminko'.$i,'">
            <option value="=="';
            if(isset($_GET['znaminko'.$i]) and $_GET['znaminko'.$i] == "=="){
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
    echo    '<input type="text" name="textkde'.$i.'" value="'. $_GET['textkde'.$i] .'">'. "\n";
    $i ++;
}
echo    '/form>'. "<br>\n";




$i = 0;
while($i != checkbox){
    if($_GET['kde'.$i] != ""){
        echo "and " . $_GET['kde'.$i] . " " . $_GET['znaminko'.$i] . " " . $_GET['textkde'.$i];
        if($i == 0 and $_GET['kde'.(1)] != ""){
            echo " " .  $_GET['andor'] . " ";
        }
    }
$i ++;
}
echo "<br>\n";

?>