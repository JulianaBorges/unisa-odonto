<?php
include 'conexao.php';
$sql = "SELECT * FROM consultas";
$resultado = mysqli_query($conn, $sql);
while($dados = mysqli_fetch_assoc($resultado)){
echo "Consulta ID: " . $dados['id'] . "<br>";
echo "Paciente: " . $dados['paciente_id'] . "<br>";
echo "Dentista: " . $dados['dentista_id'] . "<br>";
echo "Data: " . $dados['data_consulta'] . "<br>";
echo "Horário: " . $dados['horario'] . "<br>";
echo "Status: " . $dados['status'] . "<br><hr>";
}
?>