<?php

$server = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$server;dbname=reg_sys", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOExeption $e) {
    $conn->rollback();
    echo "<p>connection failed: ".$e->getMessage()."</p><br>";
    
    }