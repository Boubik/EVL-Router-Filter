<?php
$array = array(
    'servername' => '127.0.0.1',            // ip address for db mysql/mariadb
    'username' => 'root',                   // user name for db
    'password' => '',                       // password fo db
    'dbname' => 'evl',                      // db name (it autamatic create evl db if you want to change it you need to change it in function.php create_db())
    'delete_evl' => TRUE,                   // if TRUE it will delete .evl after import
    'debug_echo' => FALSE,                  // will echo more info in to_db.php
    'router' => TRUE,                       // if TRUE router id will be changet to what you want
    '2185' => "Mariánská"                   // id of router to print name);
);
$key = array_keys($array, "Mariánská");
print_r( $key);
?>