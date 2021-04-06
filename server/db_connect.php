<?php

$server = "localhost";
$user = "root";
$pass = "root";
$db_name = "projeto_mao_de_obra";

// Criando conexao
$conn = new mysqli($server, $user, $pass, $db_name);


// Checando conexao
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
