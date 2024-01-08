<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "productdb";

$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
    die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
    
}

// În db_connections.php
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>