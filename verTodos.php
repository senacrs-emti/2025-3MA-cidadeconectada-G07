<?php
include "PHP/Conexao.php";

// Fuso horário de Porto Alegre (Essencial para funcionar certo)
date_default_timezone_set('America/Sao_Paulo');
$horaAtual = date('H:i:s');

// 1. Configuração
$tipo = $_GET['tipo'] ?? 'moradia';
$tabelas = ["moradia", "alimentacao", "postosaude", "centropop"];
if (!in_array($tipo, $tabelas)) { $tipo = 'moradia'; }

$titulos = [
    "moradia" => "CENTROS DE MORADIA", 
    "alimentacao" => "ALIMENTAÇÃO POPULAR",
    "postosaude" => "POSTOS DE SAÚDE", 
    "centropop" => "CENTROS POP"
];
$tituloPagina = $titulos[$tipo];

// 2. Busca Locais (Incluindo Abertura e Fechamento)
$sql = "SELECT id, nome, endereco, lat, lng, abertura, fechamento FROM $tipo";
$result = $conn->query($sql);
$locais = [];

while ($row = $result->fetch_assoc()) {
    $row['lat'] = (float)$row['lat'];
    $row['lng'] = (float)$row['lng'];
    
    // Lógica de Aberto/Fechado
    $abertura = $row['abertura']; // ex: 08:00:00
    $fechamento = $row['fechamento']; // ex: 18:00:00
    
    if ($horaAtual >= $abertura && $horaAtual <= $fechamento) {
        $row['status'] = 'Aberto';
        $row['status_class'] = 'tag-aberto';
    } else {
        $row['status'] = 'Fechado';
        $row['status_class'] = 'tag-fechado';
    }
    
    // Formatação bonita para exibir (tira os segundos)
    $row['horario_formatado'] = date('H:i', strtotime($abertura)) . ' às ' . date('H:i', strtotime($fechamento));

    $locais[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root { --azul: #3069d5; --verde: #2ecc71; --vermelho: #e74c3c; --amarelo: #FFD700; }
        body { margin: 0; font-family: 'Poppins', sans-serif; background: var(--azul); display: flex; flex-direction: column; height: 100vh; overflow: hidden; }
        
        #mapa-container { height: 42vh; width: 100%; position: relative; }
        #map { width: 100%; height: 100%; }
        
        .btn-voltar { position: absolute; top: 15px; left: 15px; z-index: 10; background: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.3); text-decoration: none;}
        .btn-voltar img { width: 20px; }

        .header { text-align: center; color: white; padding: 10px 0; font-weight: bold; font-size: 1.1rem; text-transform: uppercase; }
        
        #filtros { display: flex; justify-content: center; gap: 10px; padding-bottom: 10px; }
        .btn-filtro { background: white; border: none; border-radius: 10px; width: 28vw; height: 70px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; }
        .btn-filtro.ativo { background: var(--amarelo); transform: scale(1.05); }
        .btn-filtro img { width: 30px; margin-bottom: 3px; }
        .btn-filtro span { font-size: 10px; font-weight: bold; }

        #lista-container { flex: 1; overflow-y: auto; padding: 10px; background: rgba(0,0,0,0.05); }
        
        .card-local {
            background: white; border-radius: 15px; padding: 15px; margin-bottom: 12px;
            display: flex; justify-content: space-between; align-items: center;
            cursor: pointer; border-left: 5px solid transparent; position: relative;
        }
        
        .destaque-proximo { border: 3px solid var(--verde) !important; background-color: #f0fff4 !important; transform: scale(1.01); }
        .tag-proximo { position: absolute; top: -10px; right: 10px; background: var(--verde); color: white; font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 10px; display: none; }
        .destaque-proximo .tag-proximo { display: block; }

        .info-txt { width: 65%; }
        .nome { font-weight: bold; font-size: 0.9rem; color: #333; margin-bottom: 4px; }
        .end { font-size: 0.7rem; color: #666; margin-bottom: 4px;}
        
        /* Badges de Status */
        .status-badge { font-size: 0.7rem; font-weight: bold; padding: 2px 6px; border-radius: 4px; color: white; display: inline-block;}
        .tag-aberto { background-color: var(--verde); }
        .tag-fechado { background-color: var(--vermelho); }
        .horario-txt { font-size: 0.65rem; color: #888; margin-left: 5px; }

        .info-rota { width: 33%; text-align: right; }
        .badge-tempo { background: #e8f0fe; color: #1967d2; font-weight: bold; font-size: 0.8rem; padding: 5px 8px; border-radius: 15px; display: inline-block; }
        .dist-txt { font-size: 0.7rem; color: #888; margin-top: 2px; }
    </style>
</head>
<body>

    <div id="mapa-container">
        <a href="TelaInicial.html" class="btn-voltar"><img src="imgs/imgsIcones/imgseta.png"></a>
        <div id="map"></div>
    </div>

    <div class="header"><?php echo $tituloPagina; ?></div>

    <div id="filtros">
        <button class="btn-filtro" onclick="mudarModo('BICYCLING', this)">
            <img src="imgs/imgsIcones/bicicletaImg.png"><span>BICICLETA</span>
        </button>
        <button class="btn-filtro" onclick="mudarModo('TRANSIT', this)">
            <img src="imgs/imgsIcones/onibusImg.png"><span>ÔNIBUS</span>
        </button>
        <button class="btn-filtro ativo" onclick="mudarModo('WALKING', this)">
            <img src="imgs/imgsIcones/andandoImg.png"><span>A PÉ</span>
        </button>
    </div>

    <div id="lista-container">
        <?php foreach ($locais as $i => $local): ?>
            <div class="card-local" id="card-<?php echo $i; ?>" 
                 onclick="tracarRota(<?php echo $local['lat']; ?>, <?php echo $local['lng']; ?>)">
                
                <div class="tag-proximo">MAIS PRÓXIMO</div>
                
                <div class="info-txt">
                    <div class="nome"><?php echo $local['nome']; ?></div>
                    <div class="end"><?php echo $local['endereco']; ?></div>
                    
                    <div>
                        <span class="status-badge <?php echo $local['status_class']; ?>">
                            <?php echo $local['status']; ?>
                        </span>
                        <span class="horario-txt"><?php echo $local['horario_formatado']; ?></span>
                    </div>
                </div>
                
                <div class="info-rota">
                    <div class="badge-tempo" id="tempo-<?php echo $i; ?>">...</div>
                    <div class="dist-txt" id="dist-<?php echo $i; ?>"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script> const locaisDados = <?php echo json_encode($locais); ?>; </script>
    <script src="mapa.js"></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0kJz1G9dw3pQMaYE3Cci1Osken1w2KuY&callback=initMap&libraries=places"></script>
</body>
</html>