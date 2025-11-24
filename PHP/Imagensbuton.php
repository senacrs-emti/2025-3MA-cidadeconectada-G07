<?php
include "Conexao.php";

$sql = "SELECT * FROM Imagensbuton";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Imagens dos Botões</title>
</head>
<body>

<h1>Imagens dos Botões</h1>

<?php
while ($row = $result->fetch_assoc()) {

    echo "<div style='padding:10px;'>";

    echo "<h3>".$row['nome']."</h3>";
    echo "<img src='".$row['caminho']."' width='120'>";

    echo "</div>";
}
$conn->close();
?>
</body>
</html>
