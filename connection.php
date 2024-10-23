<?php
// $serverName = 'it2\MSSQLSERVER01';
// $connectionOptions = [
//     'Database' => 'devicelist',
//     'Uid' => 'admin',
//     'PWD' => '12345678',
//     'CharacterSet' => 'UTF-8'
// ];
// // Establishes the connection
// $conn = sqlsrv_connect($serverName, $connectionOptions);
// if( $conn ) {
//     // echo "Connection established.<br />";
// }else{
//     echo "Connection could not be established.<br />";
//     die( print_r( sqlsrv_errors(), true));
// }
header('Content-Type: text/html; charset=utf-8');
$serverName = 'it2\MSSQLSERVER01';
$dbUserName = 'admin';
$dbPassword = '12345678';
$dbName = 'devicelist';

try {
    $conn = new PDO("sqlsrv:Server=$serverName; Database=$dbName", $dbUserName, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to SQL Server: ". $e->getMessage());
}