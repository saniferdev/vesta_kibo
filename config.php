<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(-1);

$sqlServerHost           = '192.168.130.50\TALYS';
$sqlServerDatabase       = 'x3v12prod';
$sqlServerUser           = 'CA';
$sqlServerPassword       = 'WesoKhu640Rfz0Yi';

$connectionInfo          = array("Database" => $sqlServerDatabase, "UID" => $sqlServerUser, "PWD" => $sqlServerPassword, "CharacterSet" => "UTF-8");
$link                    = sqlsrv_connect($sqlServerHost, $connectionInfo);
if (!$link) {
     die( print_r( sqlsrv_errors(), true));
}

$sqlServerHost2          = '192.168.130.64';
$sqlServerDatabase2      = 'KIBO';
$sqlServerUser2          = 'appli_kibo';
$sqlServerPassword2      = 'WesoKhu640Rfz0Yi';

$connectionInfo2         = array("Database" => $sqlServerDatabase2, "UID" => $sqlServerUser2, "PWD" => $sqlServerPassword2, "CharacterSet" => "UTF-8");
$link2                   = sqlsrv_connect($sqlServerHost2, $connectionInfo2);
if (!$link2) {
     die( print_r( sqlsrv_errors(), true));
}

?>