<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1 — conexão
$conn = new mysqli("localhost", "root", "", "atividadeotem");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// 2 — recebe tipo, id e modo
$tipo = $_GET['tipo'] ?? '';
$id   = $_GET['id'] ?? '';
$modo = $_GET['modo'] ?? '';

if ($tipo == '' || $id == '' || $modo == '') {
    die("Parâmetros inválidos!");
}

// 3 — tabelas válidas
$tabelas_validas = ['moradia','alimentacao','postosaude','centropop'];
if (!in_array($tipo, $tabelas_validas)) {
    die("Tipo inválido!");
}

// 4 — busca o registro correto
$sql = "SELECT * FROM $tipo WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Registro não encontrado!");
}

$dados = $result->fetch_assoc();

// 5 — ícone do topo
$icones = [
    "moradia"     => "casa.icon.png",
    "alimentacao" => "prato.icon.png",
    "postosaude"  => "posto.icon.png",
    "centropop"   => "pop.icon.png"
];

$icone = $icones[$tipo];

// 6 — nome da imagem do mapa
$imagemMapa = "imgs/imgsIndo/{$tipo}_{$id}_{$modo}.png";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Como Ir</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <link rel="stylesheet" href="comoIr.css?v=<?php echo time(); ?>">
</head>

<body>

<div id="caixa1">

    <img id="setaBackImg" src="imgs/imgsIcones/imgseta.png" onclick="history.back()">

    <img id="casaIcon" src="imgs/imgsIcones/<?php echo $icone; ?>">

    <h1 id="titulo">
        <?php echo $dados['endereco']; ?>
    </h1>

    <p id="descLocal">
        VOCÊ ESCOLHEU IR DE: <b><?php echo strtoupper($modo); ?></b>
    </p>

    <div id="mapa">
        <img src="<?php echo $imagemMapa; ?>" style="width:100%; height:100%; object-fit:cover;">
    </div>
</div>

<div id="automoveis">

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=bicicleta" class="atituloss">
        <div class="escolhasDeIr" id="bicicleta">
            <h3 class="tituloautomoveis">BICICLETA</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/bicicletaImg.png">
        </div>
    </a>

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=onibus" class="atituloss">
        <div class="escolhasDeIr" id="onibus">
            <h3 class="tituloautomoveis">ÔNIBUS</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/onibusImg.png">
        </div>
    </a>

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=andando" class="atituloss">
        <div class="escolhasDeIr" id="andando">
            <h3 class="tituloautomoveis">ANDANDO</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/andandoImg.png">
        </div>
    </a>

</div>

<div id="botoesadicionais">

    <a href="Informacoes.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>">
        <div id="maisInfo">
            <h4 class="textBtAdd">MAIS INFORMAÇÕES</h4>
        </div>
    </a>

    <a href="verTodos.php?tipo=<?php echo $tipo; ?>">
        <div id="verTodos">
            <h4 class="textBtAdd">VER TODOS</h4>
        </div>
    </a>

</div>

</body>
</html>
