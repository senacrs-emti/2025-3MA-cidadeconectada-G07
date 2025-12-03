<?php
// ... (Mantenha todo o seu código PHP inicial de conexão e busca do destino igualzinho) ...
// PONTO A (Fallback): Caso o usuário não aceite a localização, usamos um ponto fixo.
$origin_fallback = "Shopping Total, Porto Alegre, Brasil";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Rota: <?php echo htmlspecialchars($nome); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body, html { height: 100%; margin: 0; font-family: 'Poppins', sans-serif; }
    #map { height: 70%; width: 100%; }
    #controls { padding: 15px; background-color: #3069d5; color: white; text-align: center;}
    .card { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,.1); }
    select, button { padding:8px; font-size:16px; border-radius: 5px; border: none;}
    button { background-color: #fff; color: #3069d5; font-weight: bold; cursor: pointer; }
    h2, p { margin: 5px 0; }
</style>
</head>
<body>

<div id="controls">
    <h2>Indo para: <?php echo htmlspecialchars($nome); ?></h2>
    <p><small><?php echo htmlspecialchars($dest_address); ?></small></p>
    
    <div style="margin-top: 10px;">
        <label for="mode">Ir de:</label>
        <select id="mode">
            <option value="DRIVING">Carro</option>
            <option value="BICYCLING">Bicicleta</option>
            <option value="TRANSIT">Ônibus</option>
            <option value="WALKING">A pé</option>
        </select>
        <button id="goBtn">Atualizar Rota</button>
    </div>
    <p id="statusMsg" style="font-size: 12px; margin-top: 5px; color: #ffeb3b;"></p>
</div>

<div id="map"></div>
<div id="directionsPanel" style="height: 20%; overflow:auto; padding:10px; background: #f0f0f0;"></div>

<script>
    // Endereço de destino vindo do PHP
    const destAddress = <?php echo json_encode($dest_address, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>;
    // Endereço reserva caso o GPS falhe
    const fallbackAddress = <?php echo json_encode($origin_fallback, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>;

    let map, directionsService, directionsRenderer;

    function initMap() {
        // Inicia o mapa centralizado em Porto Alegre (será ajustado depois)
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: { lat: -30.033, lng: -51.23 }
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ 
            map: map, 
            panel: document.getElementById('directionsPanel') 
        });

        // Ao carregar, tenta pegar a localização e traçar a rota
        buscarLocalizacaoETraçarRota();

        document.getElementById('goBtn').addEventListener('click', () => {
            buscarLocalizacaoETraçarRota();
        });
    }

    function buscarLocalizacaoETraçarRota() {
        const statusMsg = document.getElementById('statusMsg');
        statusMsg.innerText = "Buscando sua localização...";

        // Verifica se o navegador suporta geolocalização
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // SUCESSO: Pega as coordenadas do usuário
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    statusMsg.innerText = "Localização encontrada! Traçando rota...";
                    traçarRota(userLocation);
                },
                (error) => {
                    // ERRO: Usuário negou ou falhou
                    console.error(error);
                    handleLocationError(true);
                }
            );
        } else {
            // Navegador não suporta
            handleLocationError(false);
        }
    }

    function handleLocationError(browserHasGeolocation) {
        const statusMsg = document.getElementById('statusMsg');
        statusMsg.innerText = browserHasGeolocation
            ? "Erro: A geolocalização falhou ou foi negada. Usando ponto padrão."
            : "Erro: Seu navegador não suporta geolocalização. Usando ponto padrão.";
        
        // Se der erro, usa o endereço fixo (Shopping Total)
        traçarRota(fallbackAddress);
    }

    function traçarRota(origem) {
        const selectedMode = document.getElementById('mode').value;

        directionsService.route({
            origin: origem, // Pode ser coordenada {lat, lng} ou string "Endereço"
            destination: destAddress,
            travelMode: google.maps.TravelMode[selectedMode]
        }, (response, status) => {
            if (status === "OK") {
                directionsRenderer.setDirections(response);
                document.getElementById('statusMsg').innerText = ""; // Limpa msg
            } else {
                window.alert("Não foi possível calcular a rota: " + status);
            }
        });
    }
</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initMap&v=weekly"
></script>
</body>
</html>