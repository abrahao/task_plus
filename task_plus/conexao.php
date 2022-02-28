<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myDB";
$port = 3307;

//Conexao com a porta
$conn = new PDO("mysql:host=$host;port=$port;dbname=".$dbname, $user, $pass);