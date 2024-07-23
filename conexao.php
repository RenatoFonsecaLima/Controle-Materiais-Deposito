<?php
$servername = "localhost";
$username = "renato";
$password = "240407";
$dbname = "estoque_depositos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
