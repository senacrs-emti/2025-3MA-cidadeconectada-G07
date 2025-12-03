# 2025-3MA-cidadeconectada-G07

asso a passo para criar a sua API Key (Google Cloud):
Como você é desenvolvedor, esse é um processo padrão que vai usar bastante. Siga estes passos:

Acesse o Google Cloud Console:

Vá para console.cloud.google.com.

Faça login com sua conta Google.

Crie um Projeto:

No topo, clique em "Selecione um projeto" -> "Novo Projeto".

Dê um nome (ex: CidadeConectada-Totem) e crie.

Ative as APIs necessárias (Isso é crucial):

No menu lateral, vá em "APIs e Serviços" > "Biblioteca".

Pesquise e ATIVE estas duas APIs (uma por uma):

Maps JavaScript API (para mostrar o mapa).

Directions API (para traçar a rota/linha azul).

Configure o Faturamento (Billing):

Atenção: O Google exige um cartão de crédito cadastrado para liberar o uso, mesmo que você não gaste nada. Eles dão US$ 200,00 de crédito mensal gratuito (o que sobra para testes e uso leve). Sem isso, a chave não funciona.

Gere a Chave (Credenciais):

Vá em "APIs e Serviços" > "Credenciais".

Clique em "+ CRIAR CREDENCIAIS" > "Chave de API".

Copie o código que aparecer (começa com AIza...).

Onde colocar no código:
Volte no seu arquivo rota.php, lá na última linha, e cole sua chave onde está escrito SUA_API_KEY_AQUI.

Vai ficar assim:

JavaScript

<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSySeuCodigoGiganteAqui&callback=initMap&v=weekly"
></script>
Dica de Debug: Se mesmo colocando a chave der erro, aperte F12 no navegador, vá na aba Console e veja a mensagem em vermelho. Geralmente o Google diz exatamente o que faltou (ex: "API Directions not enabled" ou "Billing not enabled").