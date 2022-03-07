<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myDB";
$port = 3307;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Conectado a base de dados!";
} 
catch (PDOException $e) {
    echo "Conexão com a base de dados falhou: " . $e->getMessage();
}
