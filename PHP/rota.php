<?php
// rota.php - O Arquivo Mestre de Mapas
include "Conexao.php";

// 1. Recebe os dados da URL (Ex: rota.php?tabela=alimentacao&id=1)
$tabela = isset($_GET['tabela']) ? $_GET['tabela'] : '';
$id     = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2. Validação de segurança
$tabelas_permitidas = ['alimentacao', 'moradia', 'postosaude', 'centropop'];
$endereco_destino = "";
$nome_destino = "";

if (in_array($tabela, $tabelas_permitidas) && $id > 0) {
    // Busca o endereço específico no banco
    $stmt = $conn->prepare("SELECT nome, endereco FROM $tabela WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($row = $resultado->fetch_assoc()) {
        $endereco_destino = $row['endereco']; // O Google vai ler isso (Ex: "Av. João Pessoa, 2384...")
        $nome_destino = $row['nome'];
    }
    $stmt->close();
} else {
    //se algo der errado
    $endereco_destino = "Centro Histórico, Porto Alegre";
    $nome_destino = "Destino não encontrado";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rota para <?php echo htmlspecialchars($nome_destino); ?></title>
    <style>
        body, html { height: 100%; margin: 0; font-family: 'Poppins', sans-serif; }
        #map { height: 100%; width: 100%; }
        
        /* Painel flutuante de informações */
        #painel-info {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 400px;
            background: white;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 5;
            text-align: center;
        }
        .btn-voltar {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #3069d5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div id="painel-info">
        <h3 style="margin: 0; color: #3069d5;"><?php echo htmlspecialchars($nome_destino); ?></h3>
        <p style="margin: 5px 0; font-size: 14px; color: #555;"><?php echo htmlspecialchars($endereco_destino); ?></p>
        <div id="status-gps" style="font-size: 12px; color: orange;">Buscando sua localização...</div>
        <a href="javascript:history.back()" class="btn-voltar">Voltar</a>
    </div>

    <div id="map"></div>

    <script>
        // Passa o endereço do PHP para o JS
        const destinoFinal = "<?php echo $endereco_destino; ?> - Porto Alegre, RS"; 

        let map, directionsService, directionsRenderer;

        function initMap() {
            // Inicializa o mapa
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: { lat: -30.0346, lng: -51.2177 }, // Centro de POA padrão
                disableDefaultUI: false
            });
            
            directionsRenderer.setMap(map);

            // Tenta pegar a localização
            buscarLocalizacao();
        }

        function buscarLocalizacao() {
            if (navigator.geolocation) {
                // Opções para melhorar a precisão (High Accuracy)
                const options = {
                    enableHighAccuracy: true, // Força o uso de GPS se disponível
                    timeout: 10000,
                    maximumAge: 0
                };

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const minhaPosicao = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        document.getElementById("status-gps").innerText = "Localização encontrada! Traçando rota...";
                        document.getElementById("status-gps").style.color = "green";
                        
                        traçarRota(minhaPosicao);
                    },
                    (error) => {
                        console.error(error);
                        document.getElementById("status-gps").innerText = "Erro ao obter localização. Usando Shopping Total como origem.";
                        document.getElementById("status-gps").style.color = "red";
                        // Fallback: Se der erro, sai do Shopping Total
                        traçarRota("Shopping Total, Porto Alegre");
                    },
                    options
                );
            } else {
                alert("Seu navegador não suporta geolocalização.");
            }
        }

        function traçarRota(origem) {
            const request = {
                origin: origem,
                destination: destinoFinal,
                travelMode: google.maps.TravelMode.WALKING // Padrão: A PÉ (pode mudar para DRIVING)
            };

            directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    alert('Não foi possível traçar a rota: ' + status);
                }
            });
        }
    </script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0kJz1G9dw3pQMaYE3Cci1Osken1w2KuY&callback=initMap&v=weekly">
    </script>
</body>
</html>