<?php
include "Conexao.php";

$sql = "SELECT * FROM Moradia";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Moradia</title>
</head>
<body>
<h1>Locais de Moradia</h1>

<?php
while($row = $result->fetch_assoc()) {

    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";

    echo "<h2>".$row['nome']."</h2>";
    echo "<p><strong>Endereço:</strong> ".$row['endereco']."</p>";
    echo "<p><strong>Horário:</strong> ".$row['horario']."</p>";
    echo "<p><strong>Funcionamento:</strong> ".$row['funcionamento']."</p>";
    echo "<p><strong>Telefone:</strong> ".($row['telefone'] ?? 'Não informado')."</p>";

    echo "</div>";
}
$conn->close();
?>
</body>
</html>
