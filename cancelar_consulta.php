<?php
include 'conexao.php';

// Verificar se o ID foi passado
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Excluir a consulta do banco de dados
    $sql = "DELETE FROM consultas WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)) {
        // Redirecionar com mensagem de sucesso
        header('Location: listar_consultas.php?msg=excluido');
    } else {
        // Redirecionar com mensagem de erro
        header('Location: listar_consultas.php?msg=erro');
    }
} else {
    // Redirecionar se não houver ID
    header('Location: listar_consultas.php');
}
?>