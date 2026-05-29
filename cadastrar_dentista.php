<?php
include 'conexao.php';
if(isset($_POST['salvar'])){
$nome = $_POST['nome'];
$especialidade = $_POST['especialidade'];
$cro = $_POST['cro'];
$telefone = $_POST['telefone'];
$sql = "INSERT INTO dentistas(nome, especialidade, cro, telefone)
VALUES('$nome','$especialidade','$cro','$telefone')";
mysqli_query($conn, $sql);
echo "Dentista cadastrado com sucesso!";
}
?>
<form method="POST">
<input type="text" name="nome" placeholder="Nome" required>
<input type="text" name="especialidade" placeholder="Especialidade" required>
<input type="text" name="cro" placeholder="CRO" required>
<input type="text" name="telefone" placeholder="Telefone" required>
<button type="submit" name="salvar">Salvar</button>
</form>