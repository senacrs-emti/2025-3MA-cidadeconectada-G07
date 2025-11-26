<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1 — conexão
$conn = new mysqli("localhost", "root", "", "atividadeotem");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// 2 — pega o tipo vindo da segunda página
$tipo = $_GET['tipo'] ?? '';

if ($tipo == '') {
    die("Nenhum tipo enviado!");
}

// 3 — tabelas válidas
$tabelas_validas = ['moradia','alimentacao','postosaude','centropop'];
if (!in_array($tipo, $tabelas_validas)) {
    die("Tipo inválido!");
}

// 4 — busca o mesmo registro
$sql = "SELECT * FROM $tipo LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Nenhum registro encontrado!");
}

$dados = $result->fetch_assoc();

// 5 — caminhos das imagens de ícone
$icones = [
    "moradia"     => "casa.icon.png",
    "alimentacao" => "prato.icon.png",
    "postosaude"  => "posto.icon.png",
    "centropop"   => "pop.icon.png"
];

$icone = $icones[$tipo];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações de moradia</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <link rel="stylesheet" href="informacoes.css">
</head>

<body>
<div id="caixa1">
    
    <img id="setaBackImg" src="imgs/imgsIcones/imgseta.png" alt="" onclick="history.back()">

    <!-- Ícone do serviço -->
    <img id="casaIcon" src="imgs/imgsIcones/<?php echo $icone; ?>" alt="Ícone">

    <!-- Título: nome + endereço -->
    <h1 id="titulo">
        <?php echo $dados['endereco']; ?>
    </h1>

    <!-- horário -->
    <p class="desLocais"><?php echo $dados['horario']; ?></p>

    <!-- dias de funcionamento -->
    <p class="desLocais"><?php echo $dados['funcionamento']; ?></p>

    <!-- telefone -->
    <p class="desLocais"><?php echo $dados['telefone']; ?></p>

    <!-- Foto do local -->
    <div id="mapa">
        <img 
            src="imgs/imgsfotos/<?php echo $dados['lugar']; ?>" 
            style="width:100%; height:100%; object-fit:cover;"
        >
    </div>

</div>

     <div id="automoveis">
        <a href="comoIr.html" class="atituloss">
            <div class="escolhasDeIr" id="bicicleta">
                <h3 class="tituloautomoveis">BICICLETA</h3>
                <img class="imgsTransporte" src="imgs/imgsIcones/bicicletaImg.png" alt="">
            </div>
        </a>
        
        <a href="comoIr.html" class="atituloss">
            <div class="escolhasDeIr" id="carro">
                <h3 class="tituloautomoveis">CARRO</h3>
                <img class="imgsTransporte" src="imgs/imgsIcones/carroImg.png" alt="">
            </div>
        </a>

        <a href="comoIr.html" class="atituloss">
            <div class="escolhasDeIr" id="onibus">
                <h3 class="tituloautomoveis">ÔNIBUS</h3>
                <img class="imgsTransporte" src="imgs/imgsIcones/onibusImg.png" alt="">
            </div>
        </a>

        <a href="comoIr.html" class="atituloss">
            <div class="escolhasDeIr" id="andando">
                <h3 class="tituloautomoveis">ANDANDO</h3>
                <img class="imgsTransporte" src="imgs/imgsIcones/andandoImg.png" alt="">
            </div>
        </a>

    </div>
    <div id="botoesadicionais">
        <a href="verTodasMoradias.html">
            <div id="verTodos">
                <h4 class="textBtAdd">VER TODOS</h4>
            </div>
        </a>

    </div>
</body>
</html>