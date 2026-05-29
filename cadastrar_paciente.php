<?php
include 'conexao.php';
if(isset($_POST['salvar'])){
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$data = $_POST['data_nascimento'];
$sql = "INSERT INTO pacientes(nome, cpf, telefone, email,
data_nascimento)
VALUES('$nome','$cpf','$telefone','$email','$data')";
mysqli_query($conn, $sql);
echo "Paciente cadastrado com sucesso!";
}
?>
<form method="POST">
<input type="text" name="nome" placeholder="Nome" required>
<input type="text" name="cpf" placeholder="CPF" required>
<input type="text" name="telefone" placeholder="Telefone" required>
<input type="email" name="email" placeholder="Email" required>
7
<input type="date" name="data_nascimento" required>
<button type="submit" name="salvar">Salvar</button>
</form>