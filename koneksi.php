<?php


$DB_HOST = 'localhost'; 
$DB_USERNAME = 'root';   
$DB_PASSWORD = '';       
$DB_NAME = 'web25';      


$koneksi = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);


if (!$koneksi) {
    die("KONEKSI GAGAL: " . mysqli_connect_error());
}

?>