<?php
// ==========================
// 1) CONEXÃO COM O BANCO
// ==========================
$conn = new mysqli("localhost", "root", "", "atividadeotem");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// ==========================
// 2) PEGAR TIPO DA URL
// ==========================
$tipo = $_GET['tipo'] ?? '';

if ($tipo == '') {
    die("Nenhum tipo enviado!");
}

// ==========================
// 3) DEFINIR QUAL TABELA BUSCAR
//    importante: a tabela precisa ter o mesmo nome do tipo
//    exemplo: tipo=moradia -> tabela moradia
// ==========================
$tabelas_validas = ["moradia","alimentacao","postosaude","centropop"];

if (!in_array($tipo, $tabelas_validas)) {
    die("Tipo inválido!");
}

// ==========================
// 4) BUSCAR O PRIMEIRO REGISTRO DA TABELA
// ==========================
$sql = "SELECT * FROM $tipo LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Nenhum registro encontrado!");
}

$dados = $result->fetch_assoc();
// mapa de qual ícone usar para cada tipo
$icones = [
    "moradia"     => "casa.icon.png",
    "alimentacao" => "prato.icon.png",
    "postosaude"  => "posto.icon.png",
    "centropop"   => "pop.icon.png"
];

// descobre qual ícone usar
$icone = $icones[$tipo];


?>

<!DOCTYPE html>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dados['nome']; ?></title>
    <link rel="stylesheet" href="segundaPg.css?v=<?php echo time(); ?>">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
</head>

<body>

   <div id="caixa1">

```
    <img id="setaBackImg" src="imgs/imgsIcones/imgseta.png" alt="" onclick="history.back()">

    <!-- ÍCONE DO BANCO -->
    <img 
        id="casaIcon"
        src="imgs/imgsIcones/<?php echo $icone; ?>"
        alt="Ícone"
    >


    <!-- TÍTULO DO BANCO -->
    <h1 id="titulo">
        <?php echo strtoupper($dados['nome']); ?>
    </h1>

    <div id="mapa">
        <img 
            src="imgs/imgsBanco/<?php echo $dados['foto']; ?>"
            alt="Foto do local"
            style="width: 100%; height: 100%; object-fit: cover;"
        >
    </div>


    <!-- ENDEREÇO DO BANCO -->
    <p id="descLocal">
        <?php echo $dados['endereco']; ?>
    </p>
    
</div> 

<div id="automoveis">

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&modo=bicicleta" class="atituloss">
        <div class="escolhasDeIr" id="bicicleta">
            <h3 class="tituloautomoveis">BICICLETA</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/bicicletaImg.png" alt="">
        </div>
    </a>
    
    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&modo=carro" class="atituloss">
        <div class="escolhasDeIr" id="carro">
            <h3 class="tituloautomoveis">CARRO</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/carroImg.png" alt="">
        </div>
    </a>

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&modo=onibus" class="atituloss">
        <div class="escolhasDeIr" id="onibus">
            <h3 class="tituloautomoveis">ÔNIBUS</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/onibusImg.png" alt="">
        </div>
    </a>

    <a href="comoIr.php?tipo=<?php echo $tipo; ?>&modo=andando" class="atituloss">
        <div class="escolhasDeIr" id="andando">
            <h3 class="tituloautomoveis">ANDANDO</h3>
            <img class="imgsTransporte" src="imgs/imgsIcones/andandoImg.png" alt="">
        </div>
    </a>

</div>

<div id="botoesadicionais">

    <a href="Informacoes.php?tipo=<?php echo $tipo; ?>">
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
```

</body>
</html>
