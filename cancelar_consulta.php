<?php
include 'conexao.php';
$id = $_GET['id'];
$sql = "UPDATE consultas
SET status='Cancelado'
WHERE id='$id'";
mysqli_query($conn, $sql);
header('Location: listar_consultas.php');
?>