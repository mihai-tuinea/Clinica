<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'clinica';

$connection = mysqli_connect($host, $user, $pass, $db);
if (!$connection) {
    die("Eroare conectare la MySQL: " . mysqli_connect_error());
}
?>
