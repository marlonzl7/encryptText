<?php

function criptografarTexto($texto, $chave, $iv) {
    return openssl_encrypt($texto, 'aes-256-cbc', $chave, 0, $iv);
}

function descriptografarTexto($textoCriptografado, $chave, $iv) {
    return openssl_decrypt($textoCriptografado, 'aes-256-cbc', $chave, 0, $iv);
}

// Verifica se o formulário foi enviado
$texto = $_POST['entrada'] ?? '';
$acao = $_POST['acao'] ?? '';
$textoResultado = '';
$chave = 'minha-chave-secreta-32-chars!'; // Chave de 32 caracteres para AES-256
$iv = '1234567890123456'; // Vetor de inicialização (16 caracteres)

if (!empty($texto)) {
    try {
        if ($acao === 'criptografar') {
            $textoResultado = criptografarTexto($texto, $chave, $iv);
        } elseif ($acao === 'descriptografar') {
            $textoResultado = descriptografarTexto($texto, $chave, $iv);
        }
    } catch (Exception $e) {
        $textoResultado = "Erro: " . $e->getMessage();
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/estilo/style.css">
    <link rel="shortcut icon" href="./assets/icons/encypted-icon.svg" type="image/svg+xml">
    <title>Criptografia AES</title>
</head>
<body>
    <main>
        <header>
            <h1>Criptografar Texto</h1>
        </header>
        <form action="" method="post">
            <div class="input-group">
                <div class="input-box">
                    <div class="input-box-label">
                        <label for="entrada">Entrada</label>
                    </div>
                    <textarea name="entrada" id="entrada" cols="30" rows="10" required></textarea>
                </div>
                <div class="input-box">
                    <select name="acao" id="acao" required>
                        <option value="criptografar">Criptografar</option>
                        <option value="descriptografar">Descriptografar</option>
                    </select>
                </div>
                <div class="btn">
                    <button type="submit">Executar</button>
                </div>
                <?php if (!empty($textoResultado)) : ?>
                    <div class="input-box">
                        <div class="input-box-label">
                            <label for="saida">Resultado</label>
                        </div>
                        <textarea id="saida" cols="30" rows="10" disabled><?php echo htmlspecialchars($textoResultado); ?></textarea>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </main>
</body>
</html>
