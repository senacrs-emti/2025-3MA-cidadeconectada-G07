// mapa.js - Lógica do Google Maps separada
let map, directionsService, directionsRenderer, userPos;
let currentMode = 'WALKING'; // Modo padrão: A pé

function initMap() {
    // 1. Inicia serviços do Google
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers: false, // Deixa o Google criar os marcadores A e B da rota
        polylineOptions: { strokeColor: "#3069d5", strokeWeight: 5 }
    });

    // 2. Cria o mapa visual (Centro POA padrão)
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: { lat: -30.0277, lng: -51.2287 },
        disableDefaultUI: true, // Remove botões extras para visual limpo
        styles: [ { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] } ]
    });

    directionsRenderer.setMap(map);

    // 3. Tenta pegar o GPS do usuário
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                userPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                // Marcador azul "Você está aqui"
                new google.maps.Marker({
                    position: userPos,
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: "#4285F4",
                        fillOpacity: 1,
                        strokeColor: "white",
                        strokeWeight: 2,
                    },
                    title: "Você"
                });

                map.setCenter(userPos);
                map.setZoom(13);

                // Se a lista de locais veio do PHP, calcula as distâncias agora
                if (typeof locaisDados !== 'undefined') {
                    calcularDistancias();
                }
            },
            () => { console.warn("GPS não autorizado ou indisponível."); }
        );
    }
}

function calcularDistancias() {
    if (!userPos || !locaisDados || locaisDados.length === 0) return;
    
    const service = new google.maps.DistanceMatrixService();
    // Prepara os destinos para a API
    const destinos = locaisDados.map(l => ({ lat: l.lat, lng: l.lng }));

    service.getDistanceMatrix({
        origins: [userPos],
        destinations: destinos,
        travelMode: google.maps.TravelMode[currentMode]
    }, (res, status) => {
        if (status === "OK") {
            const elements = res.rows[0].elements;
            
            let menorDistancia = Infinity;
            let indexMaisProximo = -1;

            elements.forEach((el, i) => {
                const divTempo = document.getElementById(`tempo-${i}`);
                const divDist = document.getElementById(`dist-${i}`);
                const card = document.getElementById(`card-${i}`);
                
                // Remove destaque anterior
                if(card) card.classList.remove('destaque-proximo');

                if (el.status === "OK") {
                    // Atualiza texto na tela
                    if(divTempo) divTempo.innerText = el.duration.text;
                    if(divDist) divDist.innerText = el.distance.text;

                    // Verifica se este é o mais próximo (menor valor em metros)
                    if (el.distance.value < menorDistancia) {
                        menorDistancia = el.distance.value;
                        indexMaisProximo = i;
                    }
                } else {
                    if(divTempo) divTempo.innerText = "-";
                }
            });

            // Aplica o destaque VERDE no vencedor e move para o topo
            if (indexMaisProximo !== -1) {
                const vencedor = document.getElementById(`card-${indexMaisProximo}`);
                if(vencedor) {
                    vencedor.classList.add('destaque-proximo');
                    // Truque para mover o elemento para o topo da lista
                    vencedor.parentNode.prepend(vencedor);
                }
            }
        }
    });
}

function tracarRota(lat, lng) {
    if (!userPos) { alert("Aguardando localização do GPS..."); return; }
    
    // Rola a tela suavemente até o mapa
    document.getElementById('mapa-container').scrollIntoView({ behavior: 'smooth' });

    // Pede a rota ao Google
    directionsService.route({
        origin: userPos,
        destination: { lat: lat, lng: lng },
        travelMode: google.maps.TravelMode[currentMode]
    }, (res, status) => {
        if (status === 'OK') {
            directionsRenderer.setDirections(res);
        } else {
            alert('Não foi possível traçar a rota. Tente outro meio de transporte.');
        }
    });
}

function mudarModo(modo, btn) {
    // Atualiza visual dos botões (amarelo no ativo)
    document.querySelectorAll('.btn-filtro').forEach(b => b.classList.remove('ativo'));
    btn.classList.add('ativo');

    currentMode = modo;

    // Coloca "..." nos textos enquanto recalcula
    if (typeof locaisDados !== 'undefined') {
        locaisDados.forEach((_, i) => {
            const t = document.getElementById(`tempo-${i}`);
            if(t) t.innerText = "...";
        });
    }
    
    // Recalcula tudo com o novo modo de transporte
    calcularDistancias();
}