<?php
include "PHP/Conexao.php";
$msg = "";
$senhaCorreta = "admin"; // Senha

// Verifica login
$logado = false;
if (isset($_POST['senha']) && $_POST['senha'] === $senhaCorreta) { $logado = true; }
elseif (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') { $logado = true; }

// Cadastro
if ($logado && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $tabela = $_POST['tabela'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    
    // Novos campos de hora
    $abertura = $_POST['abertura'];
    $fechamento = $_POST['fechamento'];

    $sql = "INSERT INTO $tabela (nome, endereco, lat, lng, abertura, fechamento) 
            VALUES ('$nome', '$endereco', '$lat', '$lng', '$abertura', '$fechamento')";
    
    if ($conn->query($sql) === TRUE) {
        $msg = "<p style='color:green; font-weight:bold;'>Local cadastrado com sucesso!</p>";
    } else {
        $msg = "<p style='color:red'>Erro: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cidade Conectada</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 90%; max-width: 400px; }
        input, select, button { width: 100%; padding: 12px; margin: 8px 0; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #3069d5; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #2553a8; }
        h2 { text-align: center; color: #3069d5; margin-top: 0; }
        .voltar { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #555; font-size: 12px;}
        .row { display: flex; gap: 10px; }
    </style>
</head>
<body>

    <div class="box">
        <?php if (!$logado): ?>
            <h2>Acesso Restrito</h2>
            <form method="POST">
                <input type="password" name="senha" placeholder="Senha de Admin" required>
                <button type="submit">Entrar</button>
            </form>
            <a href="TelaInicial.html" class="voltar">Voltar ao Início</a>

        <?php else: ?>
            <h2>Novo Local</h2>
            <?php echo $msg; ?>
            
            <form method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <input type="hidden" name="senha" value="<?php echo $senhaCorreta; ?>">

                <label>Categoria:</label>
                <select name="tabela">
                    <option value="moradia">Moradia</option>
                    <option value="alimentacao">Alimentação (Restaurante Popular)</option>
                    <option value="postosaude">Posto de Saúde</option>
                    <option value="centropop">Centro Pop</option>
                </select>

                <input type="text" name="nome" placeholder="Nome do Local" required>
                <input type="text" name="endereco" placeholder="Endereço Completo" required>
                
                <div class="row">
                    <input type="text" name="lat" placeholder="Lat (ex: -30.03)" required>
                    <input type="text" name="lng" placeholder="Lng (ex: -51.22)" required>
                </div>
                
                <label>Horário de Funcionamento:</label>
                <div class="row">
                    <div style="flex:1">
                        <small>Abre:</small>
                        <input type="time" name="abertura" required>
                    </div>
                    <div style="flex:1">
                        <small>Fecha:</small>
                        <input type="time" name="fechamento" required>
                    </div>
                </div>

                <button type="submit">Salvar Local</button>
            </form>
            <a href="TelaInicial.html" class="voltar">Sair do Admin</a>
        <?php endif; ?>
    </div>

</body>
</html>