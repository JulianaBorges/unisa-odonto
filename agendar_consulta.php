<?php
include 'conexao.php';
if(isset($_POST['agendar'])){
$paciente = $_POST['paciente'];
$dentista = $_POST['dentista'];
$data = $_POST['data'];
$horario = $_POST['horario'];
$procedimento = $_POST['procedimento'];
$verifica = "SELECT * FROM consultas
WHERE dentista_id='$dentista'
AND data_consulta='$data'
AND horario='$horario'";
$resultado = mysqli_query($conn, $verifica);
if(mysqli_num_rows($resultado) > 0){
echo "Horário indisponível!";
} else {
$sql = "INSERT INTO consultas
(paciente_id, dentista_id, data_consulta, horario, procedimento,
status)
VALUES
('$paciente','$dentista','$data','$horario','$procedimento','Confirmado')";
mysqli_query($conn, $sql);
echo "Consulta agendada com sucesso!";
}
}
?>
<form method="POST">
<input type="number" name="paciente" placeholder="ID Paciente" required>
<input type="number" name="dentista" placeholder="ID Dentista" required>
<input type="date" name="data" required>
<input type="time" name="horario" required>
<input type="text" name="procedimento" placeholder="Procedimento" required>
9
<button type="submit" name="agendar">Agendar</button>
</form>