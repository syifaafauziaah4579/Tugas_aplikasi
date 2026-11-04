<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "dbadiwiyata";

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn) {
    die("koneksi database gagal:" . mysqli_connect_error());
}
?>