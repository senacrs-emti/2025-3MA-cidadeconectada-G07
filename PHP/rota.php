<?php
// rota.php
// include "Conexao.php"; // Comentei o banco para o teste

// --- DADOS FIXOS PARA TESTE (JÁ QUE TIRAMOS O BANCO) ---
$nome_destino = "Destino de Teste (Mercado Público)";
$endereco_destino = "Mercado Público de Porto Alegre, Brasil"; 

// PONTO DE RESERVA: Caso o usuário não aceite compartilhar a localização
$origem_reserva = "Shopping Total, Porto Alegre, Brasil";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rota: <?php echo htmlspecialchars($nome_destino); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    <style>
        body, html { height: 100%; margin: 0; font-family: 'Poppins', sans-serif; background-color: #3069d5; }
        
        #container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        #controls {
            padding: 15px;
            background-color: #fff;
            border-bottom: 2px solid #ddd;
            text-align: center;
            flex-shrink: 0; 
        }

        h2 { margin: 0 0 10px 0; color: #3069d5; font-size: 1.2rem; }
        p { margin: 5px 0; font-size: 0.9rem; color: #555; }

        select, button {
            padding: 10px;
            font-size: 1rem;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #map {
            flex-grow: 1; 
            width: 100%;
        }

        #statusMsg {
            font-size: 0.8rem;
            color: #d9534f;
            margin-top: 5px;
            min-height: 20px;
        }
        
        .btn-voltar {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: #3069d5;
            font-weight: bold;
            font-size: 0.8rem;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div id="container">
    <a href="javascript:history.back()" class="btn-voltar">⬅ Voltar</a>

    <div id="controls">
        <h2>Indo para: <?php echo htmlspecialchars($nome_destino); ?></h2>
        <p><strong>Destino:</strong> <?php echo htmlspecialchars($endereco_destino); ?></p>
        
        <label for="mode">Modo:</label>
        <select id="mode" onchange="atualizarRota()">
            <option value="DRIVING">Carro</option>
            <option value="TRANSIT">Ônibus</option>
            <option value="WALKING">A pé</option>
            <option value="BICYCLING">Bicicleta</option>
        </select>
        
        <div id="statusMsg">Buscando sua localização...</div>
    </div>

    <div id="map"></div>
</div>

<script>
    // Passando variáveis do PHP para o JavaScript
    const destinoFinal = <?php echo json_encode($endereco_destino); ?>;
    const origemReserva = <?php echo json_encode($origem_reserva); ?>;

    let map, directionsService, directionsRenderer;
    let minhaLocalizacao = null; 

    function initMap() {
        const mapOptions = {
            zoom: 14,
            center: { lat: -30.033, lng: -51.23 }, 
            disableDefaultUI: false 
        };

        map = new google.maps.Map(document.getElementById("map"), mapOptions);

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            map: map
        });

        buscarLocalizacao();
    }

    function buscarLocalizacao() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    minhaLocalizacao = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    document.getElementById("statusMsg").style.color = "green";
                    document.getElementById("statusMsg").innerText = "Localização encontrada!";
                    traçarRota(minhaLocalizacao);
                },
                (error) => {
                    console.error("Erro GPS:", error);
                    usarReserva("Não foi possível acessar sua localização. Usando ponto padrão.");
                }
            );
        } else {
            usarReserva("Seu navegador não suporta geolocalização.");
        }
    }

    function usarReserva(msg) {
        document.getElementById("statusMsg").style.color = "#d9534f"; 
        document.getElementById("statusMsg").innerText = msg;
        minhaLocalizacao = origemReserva; 
        traçarRota(minhaLocalizacao);
    }

    function atualizarRota() {
        if (minhaLocalizacao) {
            traçarRota(minhaLocalizacao);
        }
    }

    function traçarRota(origem) {
        const modoViagem = document.getElementById("mode").value;

        const request = {
            origin: origem,
            destination: destinoFinal,
            travelMode: google.maps.TravelMode[modoViagem]
        };

        directionsService.route(request, (response, status) => {
            if (status === "OK") {
                directionsRenderer.setDirections(response);
            } else {
                window.alert("Erro ao calcular rota: " + status);
            }
        });
    }
</script>


<script async aqui em SUA_API_KEY_AQUI é preciso ver o README.md
    src="https://maps.googleapis.com/maps/api/js?key=SUA_API_KEY_AQUI&callback=initMap&v=weekly"
></script>

</body>
</html>