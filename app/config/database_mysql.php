<?php

define('DB_USER', $_SERVER['HTTP_HOST'] != 'localhost' ? "eltb15" : "root");

define('DB_PASSWORD', $_SERVER['HTTP_HOST'] != 'localhost' ? "JQ.[7s%L" : "");

define('DB_DSN', $_SERVER['HTTP_HOST'] != 'localhost' ? "mysql:host=blu-ray.student.bth.se;dbname=eltb15" : "mysql:host=localhost;dbname=test");

return [
    // Set up details on how to connect to the database
    'dsn'     => DB_DSN,
    'username'        => DB_USER,
    'password'        => DB_PASSWORD,
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "phpmvc10_",

    // Display details on what happens
    //'verbose' => true,

    // Throw a more verbose exception when failing to connect
    //'debug_connect' => 'true',
];
