<?php
include "Conexao.php";

$sql = "SELECT * FROM Postosaude";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Postos de Saúde</title>
</head>
<body>

<h1>Postos de Saúde</h1>

<?php
while ($row = $result->fetch_assoc()) {

    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";

    echo "<h2>".$row['nome']."</h2>";
    echo "<p><strong>Endereço:</strong> ".$row['endereco']."</p>";
    echo "<p><strong>Horário:</strong> ".$row['horario']."</p>";
    echo "<p><strong>Funcionamento:</strong> ".$row['funcionamento']."</p>";
    echo "<p><strong>Telefone:</strong> ".$row['telefone']."</p>";

    echo "</div>";
}
$conn->close();
?>
</body>
</html>
