<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada - Adega Digital</title>
    <!-- Estilos CSS do projeto -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>

    <!-- Cabeçalho -->
    <header>
        <div class="header-content">
            <h1>🍷 Adega Digital</h1>
            <nav>
                <a href="<?= BASE_URL ?>">Início</a>
            </nav>
        </div>
    </header>

    <!-- Cartão de mensagem de Erro 404 -->
    <div class="container">
        <div class="form-card" style="text-align: center; max-width: 500px; margin-top: 3rem;">
            <h1 style="font-size: 4rem; margin: 0; color: #5a1827;">404</h1>
            <h2>Página Não Encontrada</h2>
            <p>O recurso ou página que estás a tentar aceder não existe.</p>
            <br>
            <a href="<?= BASE_URL ?>" class="btn btn-primary">Voltar ao Catálogo</a>
        </div>
    </div>

</body>
</html>