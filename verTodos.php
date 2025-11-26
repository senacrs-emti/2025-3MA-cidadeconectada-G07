<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1) Conexão
$conn = new mysqli("localhost", "root", "", "atividadeotem");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// 2) Tipo recebido pela URL
$tipo = $_GET['tipo'] ?? '';

$tabelas_validas = ["moradia","alimentacao","postosaude","centropop"];

if (!in_array($tipo, $tabelas_validas)) {
    die("Tipo inválido!");
}

// 3) Buscar TODOS os registros da tabela
$sql = "SELECT * FROM $tipo";
$result = $conn->query($sql);

// 4) Configurações para cada tipo
$icones = [
    "moradia"     => "casa.icon.png",
    "alimentacao" => "prato.icon.png",
    "postosaude"  => "posto.icon.png",
    "centropop"   => "pop.icon.png"
];

$titulos = [
    "moradia"     => "TODOS OS CENTROS DE MORADIA",
    "alimentacao" => "TODOS OS CENTROS DE ALIMENTAÇÃO",
    "postosaude"  => "TODOS OS POSTOS DE SAÚDE",
    "centropop"   => "TODOS OS CENTROS POP"
];

$css_arquivos = [
    "moradia"     => "verTodasMoradias.css",
    "alimentacao" => "verTodosAlimentação.css",
    "postosaude"  => "verTodosPosto.css",
    "centropop"   => "verTodosPop.css"
];

$icone = $icones[$tipo];
$titulo = $titulos[$tipo];
$css   = $css_arquivos[$tipo];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>?v=<?php echo time(); ?>">
</head>

<body>

<div id="caixa1">
    <img id="setaBackImg" src="imgs/imgsIcones/imgseta.png" onclick="history.back()">
    <img id="casaIcon" src="imgs/imgsIcones/<?php echo $icone; ?>">
    <h1 id="titulo"><?php echo $titulo; ?></h1>
</div>

<div id="listaLocais">
<?php while ($row = $result->fetch_assoc()) { ?>
    
    <a href="informacoes.php?tipo=<?php echo $tipo; ?>&id=<?php echo $row['id']; ?>">
        <div class="locais">
            <p class="nomesLocais">
                <?php echo $row['endereco']; ?>
            </p>
        </div>
    </a>

<?php } ?>
</div>

<div id="botoesadicionais">
    <a href="TelaInicial.html">
        <div id="Voltar">
            <h4 class="textBtAdd">VOLTAR PARA A TELA INICIAL</h4>
        </div>
    </a>
</div>

</body>
</html>
