<?php
return array(
    'servername' => '127.0.0.1',            // ip address for db mysql/mariadb
    'username' => 'root',                   // user name for db
    'password' => '',                       // password fo db
    'dbname' => 'evl',                      // db name (it automatically create db with that name)

    'dialog_echo' => FALSE,                   // if TRUE it will echo basic info
    'debug_echo' => FALSE,                   // will echo more info in to_db.php
    'log_print' => TRUE,                    // if TRUE it will write to /log
    'delete_evl' => FALSE,                   // if TRUE it will delete .evl after import

    'insert' => 3600,                        //rows per one insert

    'router' => TRUE,                       // if TRUE router id will be changet to what you want
    '2179' => "Mariánská",                   // id of router to print name
    '2185' => "Karolína Světlá"              // id of router to print name
);
?>