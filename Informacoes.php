<?php
// Informacoes.php
include "PHP/Conexao.php"; 

$tipo = $_GET['tipo'] ?? '';
$id   = $_GET['id'] ?? 0;

if ($tipo == '' || $id == 0) { die("Erro: Dados inválidos."); }

// Busca dados
$sql = "SELECT * FROM $tipo WHERE id = $id";
$result = $conn->query($sql);
$dados = $result->fetch_assoc();

// Ícones
$icones = [
    "moradia" => "casa.icon.png", "alimentacao" => "prato.icon.png",
    "postosaude" => "posto.icon.png", "centropop" => "pop.icon.png"
];
$icone = $icones[$tipo] ?? "casa.icon.png";

// Determina qual imagem de mapa usar (do banco ou padrão)
$imagemMapa = !empty($dados['foto']) ? $dados['foto'] : "mapaPopUm.png"; // Fallback
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações</title>
    <link rel="stylesheet" href="informacoes.css?v=2">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
</head>
<body>

    <div id="caixa1">
        <img id="setaBackImg" src="imgs/imgsIcones/imgseta.png" onclick="history.back()">
        
        <div style="text-align: center; margin-top: 2vh;">
            <img id="casaIcon" src="imgs/imgsIcones/<?php echo $icone; ?>" alt="Ícone">
            <h1 id="titulo" style="margin-bottom: 5px;">
                CENTRO MAIS PERTO DE VOCÊ
            </h1>
        </div>

        <div class="mapa-quadrado">
            <a href="PHP/rota.php?tabela=<?php echo $tipo; ?>&id=<?php echo $id; ?>">
                <img src="imgs/imgsMapas/<?php echo $imagemMapa; ?>" alt="Mapa Estático">
                <div class="ver-rota-btn">📍 TOCAR PARA VER ROTA</div>
            </a>
        </div>

        <h2 style="text-align:center; color:white; font-size: 2.2vh; width: 80%; margin: 0 auto;">
            <?php echo $dados['nome']; ?>
        </h2>
        <p class="desLocais" style="margin-top: 1vh;">
            <?php echo $dados['endereco']; ?>
        </p>
    </div>

    <div id="automoveis-container">
        
        <a href="PHP/rota.php?tabela=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=BICYCLING">
            <div class="botao-transporte">
                <h3 class="titulo-btn">BICICLETA</h3>
                <img src="imgs/imgsIcones/bicicletaImg.png" alt="Bike">
            </div>
        </a>

        <a href="PHP/rota.php?tabela=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=TRANSIT">
            <div class="botao-transporte">
                <h3 class="titulo-btn">ÔNIBUS</h3>
                <img src="imgs/imgsIcones/onibusImg.png" alt="Bus">
            </div>
        </a>

        <a href="PHP/rota.php?tabela=<?php echo $tipo; ?>&id=<?php echo $id; ?>&modo=WALKING">
            <div class="botao-transporte">
                <h3 class="titulo-btn">ANDANDO</h3>
                <img src="imgs/imgsIcones/andandoImg.png" alt="Walk">
            </div>
        </a>

    </div>

    <div id="botoesadicionais">
        <a href="verTodos.php?tipo=<?php echo $tipo; ?>">
            <div id="verTodos">
                <h4 class="textBtAdd">VER OUTROS LOCAIS</h4>
            </div>
        </a>
    </div>

</body>
</html>