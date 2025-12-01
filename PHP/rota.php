<?php
// rota.php
include "conexao.php";

// Recebe parâmetros
$table = isset($_GET['table']) ? $_GET['table'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// validar tabela (evitar SQL injection por tabela nome)
$allowed = ['alimentacao','moradia','postosaude','centropop','imagensbuton'];
if (!in_array($table, $allowed)) {
    die("Tabela inválida.");
}

if ($id <= 0) {
    die("ID inválido.");
}

// Buscar endereço do banco
$stmt = $conn->prepare("SELECT nome, endereco FROM {$table} WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die("Registro não encontrado.");
}
$row = $res->fetch_assoc();
$nome = $row['nome'];
// o campo endereco pode conter quebras; limpamos
$dest_address = trim(preg_replace("/\s+/", " ", $row['endereco']));

$stmt->close();
$conn->close();

// PONTO A: Shopping Total — ajuste se quiser outro texto/exato endereço
$origin_address = "Shopping Total, Porto Alegre, Brasil";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Rota: <?php echo htmlspecialchars($nome); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body, html { height: 100%; margin: 0; font-family: Arial, sans-serif; }
    #map { height: 70%; }
    #controls { padding: 10px; }
    .card { padding: 10px; background:#fff; box-shadow:0 1px 3px rgba(0,0,0,.1); margin-bottom:8px; }
    label { margin-right:8px; }
    select, button { padding:6px; font-size:14px; }
</style>
</head>
<body>
<div class="card">
    <h2>Rota para: <?php echo htmlspecialchars($nome); ?></h2>
    <p><strong>Destino:</strong> <?php echo htmlspecialchars($dest_address); ?></p>
    <p><strong>Origem (Ponto A):</strong> <?php echo htmlspecialchars($origin_address); ?></p>

    <div id="controls">
    <label for="mode">Escolha o modo:</label>
    <select id="mode">
        <option value="DRIVING">Carro</option>
        <option value="BICYCLING">Bicicleta</option>
        <option value="TRANSIT">Ônibus / Transporte público</option>
        <option value="WALKING">A pé</option>
    </select>
    <button id="goBtn">Traçar rota</button>
    <button id="resetBtn">Centralizar mapa</button>
    </div>
</div>

<div id="map"></div>
<div id="directionsPanel" style="height: 30%; overflow:auto; padding:10px;"></div>

<script>
    // Variáveis vindas do PHP
    const originAddress = <?php echo json_encode($origin_address, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>;
    const destAddress   = <?php echo json_encode($dest_address, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>;

    let map, directionsService, directionsRenderer;

    function initMap() {
      // mapa inicial centrado no ponto A (Shopping Total)
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 14,
        center: { lat: -30.033, lng: -51.23 } // Coordenada aproximada de Porto Alegre; será recentered ao traçar rota
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({ map: map, panel: document.getElementById('directionsPanel') });
    
      // desenhar rota automaticamente ao carregar
    calculateAndDisplayRoute();

    document.getElementById('goBtn').addEventListener('click', () => {
        calculateAndDisplayRoute();
    });

    document.getElementById('resetBtn').addEventListener('click', () => {
        map.setCenter({ lat: -30.033, lng: -51.23 });
        map.setZoom(14);
    });
    }

    function calculateAndDisplayRoute() {
      const selectedMode = document.getElementById('mode').value; // DRIVING, BICYCLING, TRANSIT, WALKING

      // Monta a requisição para DirectionsService
    directionsService.route({
        origin: originAddress,
        destination: destAddress,
        travelMode: google.maps.TravelMode[selectedMode],
        provideRouteAlternatives: false
    }, (response, status) => {
        if (status === "OK") {
        directionsRenderer.setDirections(response);
        } else {
        alert("Falha ao traçar rota: " + status + ". Tente outro modo (ex: TRANSIT pode não estar disponível).");
        }
    });
    }
</script>


<script async
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initMap&v=weekly"
></script>
</body>
</html>
