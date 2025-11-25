<?php
// CONEXÃO COM O BANCO
$conn = new mysqli("localhost", "root", "", "atividadeotem");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// pego o tipo da URL
$tipo = $_GET['tipo'] ?? '';

if ($tipo == '') {
    die("Nenhum tipo enviado!");
}

// defino qual tabela acessar
$tabelas_validas = ['moradia','alimentacao','postosaude','centropop'];

if (!in_array($tipo, $tabelas_validas)) {
    die("Tipo inválido!");
}

// buscar o primeiro registro da tabela
$sql = "SELECT * FROM $tipo LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Nenhum registro encontrado!");
}

$dados = $result->fetch_assoc();
?>
