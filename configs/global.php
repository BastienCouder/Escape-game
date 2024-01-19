<?php 
$dbConfig = json_decode(file_get_contents('./config.json'), true);

$globalConfigs = 
[
    "debugMode" => true,
    "database" => [
        "db_name" => $dbConfig['db_name'],
        "host" => $dbConfig['host'],
        "port" => $dbConfig['port'],
        "user" => $dbConfig['user'],
        "password" => $dbConfig['password']
    ]
];