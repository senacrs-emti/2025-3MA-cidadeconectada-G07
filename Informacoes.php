<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1 — conexão
$conn = new mysqli("localhost", "root", "", "atividadeotem");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// 2 — pega tipo
$tipo = $_GET['tipo'] ?? '';
if ($tipo == '') {
    die("Nenhum tipo enviado!");
}

// ➤ pega o id da URL
$id = $_GET['id'] ?? 0;
if ($id == 0) {
    die("ID não informado!");
}

// 3 — tabelas válidas
$tabelas_validas = ['moradia','alimentacao','postosaude','centropop'];
if (!in_array($tipo, $tabelas_validas)) {
    die("Tipo inválido!");
}

// 4 — busca o registro correto
$sql = "SELECT * FROM $tipo WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Registro não encontrado!");
}

$dados = $result->fetch_assoc();

// 5 — ícones
$icones = [
    "moradia"     => "casa.icon.png",
    "alimentacao" => "prato.icon.png",
    "postosaude"  => "posto.icon.png",
    "centropop"   => "pop.icon.png"
];

$icone = $icones[$tipo];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Totem</title>
    <link rel="icon" href="imgs/imgFavicon" type="image/x-icon">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <link rel="stylesheet" href="informacoes.css">
    
    <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>
</head>

<body>
<div id="caixa1">
    
    <img id="setaBackImg" src="imgs/imgsIcones/imgseta.png" alt="" onclick="history.back()">

    <img id="casaIcon" src="imgs/imgsIcones/<?php echo $icone; ?>" alt="Ícone">

    <h1 id="titulo">
        <?php echo $dados['endereco']; ?>
    </h1>

    <p class="desLocais"><?php echo $dados['horario']; ?></p>
    <p class="desLocais"><?php echo $dados['funcionamento']; ?></p>
    <p class="desLocais"><?php echo $dados['telefone']; ?></p>

    <div id="mapa">
        <img 
            src="imgs/imgsfotos/<?php echo $dados['lugar']; ?>" 
            style="width:100%; height:100%; object-fit:cover;"
        >
    </div>

</div>
<div id="automoveis">

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=bicicleta" class="atituloss">
        <div class="escolhasDeIr" id="bicicleta">
            <h3 class="tituloautomoveis">BICICLETA</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/bicicletaImg.png" alt="">
        </div>
    </a>

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=carro" class="atituloss">
        <div class="escolhasDeIr" id="carro">
            <h3 class="tituloautomoveis">CARRO</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/carroImg.png" alt="">
        </div>
    </a>

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=onibus" class="atituloss">
        <div class="escolhasDeIr" id="onibus">
            <h3 class="tituloautomoveis">ÔNIBUS</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/onibusImg.png" alt="">
        </div>
    </a>

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=andando" class="atituloss">
        <div class="escolhasDeIr" id="andando">
            <h3 class="tituloautomoveis">ANDANDO</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/andandoImg.png" alt="">
        </div>
    </a>

</div>


<div id="botoesadicionais">
    <a href="verTodos.php?tipo=<?php echo $tipo; ?>">
        <div id="verTodos">
            <h4 class="textBtAdd">VER TODOS</h4>
        </div>
    </a>
</div>

</body>
</html>
