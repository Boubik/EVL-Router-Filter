<?php
return array(
    'servername' => '127.0.0.1',            // ip address for db mysql/mariadb
    'username' => 'root',                   // user name for db
    'password' => '',                       // password fo db
    'dbname' => 'evl',                      // db name (it autamatic create evl db if you want to change it you need to change it in function.php create_db())

    'debug_echo' => FALSE,                   // will echo more info in to_db.php
    'delete_evl' => TRUE,                   // if TRUE it will delete .evl after import

    'router' => TRUE,                       // if TRUE router id will be changet to what you want
    '2179' => "Mariánská",                   // id of router to print name
    '2185' => "Karolína Světlá"              // id of router to print name
);
?>