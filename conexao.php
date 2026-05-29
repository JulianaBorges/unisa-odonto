<?php
$host = "127.0.0.1:3308";
$user = "root";
$password = "";
$database = "odontoclinica";
$conn = mysqli_connect($host, $user, $password, $database);
if(!$conn){
die("Erro na conexão");
}
?>