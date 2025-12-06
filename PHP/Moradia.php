<?php
include "Conexao.php";

/* Ponto fixo: Shopping Total */
$shopping_lat = -30.027723;
$shopping_lng = -51.214000;

/* Função Haversine */
function haversine($lat1, $lon1, $lat2, $lon2) {
    $R = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);

    return 2 * $R * atan2(sqrt($a), sqrt(1-$a));
}

/* BUSCA NO BANCO */
$sql = "SELECT * FROM Moradia";
$res = $conn->query($sql);

$moradias = [];
$mais_proxima = null;
$menor_dist = 999999;

/* Calcula distância da mais próxima */
while ($row = $res->fetch_assoc()) {

    if (!empty($row["lat"]) && !empty($row["lng"])) {
        $dist = haversine($shopping_lat, $shopping_lng, $row["lat"], $row["lng"]);
        $row["distancia"] = $dist;

        if ($dist < $menor_dist) {
            $menor_dist = $dist;
            $mais_proxima = $row;
        }
    }

    $moradias[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Totem</title>
    <link rel="stylesheet" href="./verTodasMoradias.css">
</head>

<body>
    <div id="caixa1">
        <img id="setaBackImg" src="imgs/imgsIcones/imgseta.png" onclick="history.back()">
        <img id="casaIcon" src="imgs/imgsIcones/casa.icon.png">
        <h1 id="titulo">TODOS OS CENTROS DE MORADIA</h1>
    </div>

    <!-- MAPA -->
    <div id="map" style="width:100%; height:270px; margin-bottom:20px;"></div>

    <script>
    function initMap() {
        const shopping = { lat: <?php echo $shopping_lat ?>, lng: <?php echo $shopping_lng ?> };

        const destino = {
            lat: <?php echo $mais_proxima["lat"] ?>,
            lng: <?php echo $mais_proxima["lng"] ?>
        };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: shopping
        });

        new google.maps.Marker({
            position: shopping,
            map: map,
            label: "A",
            title: "Shopping Total"
        });

        new google.maps.Marker({
            position: destino,
            map: map,
            label: "B",
            title: "<?php echo $mais_proxima['nome']; ?>"
        });
    }
    </script>

    <script async src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initMap"></script>


    <!-- LISTA DOS LOCAIS -->
    <div id="listaLocais">

        <!-- PRIMEIRO: O MAIS PRÓXIMO -->
        <a href="rota.php?table=Moradia&id=<?php echo $mais_proxima['id']; ?>">
            <div class="locais" style="border: 2px solid #4CAF50;">
                <p class="nomesLocais">
                    <strong>Mais próximo:</strong><br>
                    <?php echo $mais_proxima['nome']; ?> -
                    <?php echo $mais_proxima['endereco']; ?>
                    <br><strong><?php echo round($mais_proxima['distancia'], 2); ?> km</strong>
                </p>
            </div>
        </a>

        <!-- OUTROS LOCAIS -->
        <?php foreach ($moradias as $m) {
            if ($m["id"] == $mais_proxima["id"]) continue;
        ?>
        <a href="rota.php?table=Moradia&id=<?php echo $m['id']; ?>">
            <div class="locais">
                <p class="nomesLocais">
                    <?php echo $m['nome']; ?> -
                    <?php echo $m['endereco']; ?>
                </p>
            </div>
        </a>
        <?php } ?>

    </div>

    <div id="botoesadicionais">
        <a href="TelaInicial.html">
            <div id="Voltar">
                <h4 class="textBtAdd">VOLTAR PARA A TELA INICIAL</h4>
            </div>
        </a>
    </div>

</body>
</html>
