<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lixeira - Adega Digital</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>

    <header>
        <div class="header-content">
            <h1>🍷 Adega Digital</h1>
            <nav>
                <a href="<?= BASE_URL ?>">Início</a>
                <a href="<?= BASE_URL ?>vinhos/criar">+ Adicionar Vinho</a>
                <a href="<?= BASE_URL ?>autores">Autores</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>🗑️ Lixeira de Vinhos</h2>
        <p>Estes vinhos foram removidos do catálogo. Podes restaurá-los ou eliminá-los definitivamente.</p>

        <div class="grid-vinhos" style="margin-top: 1.5rem;">
            <?php if (!empty($data['vinhos'])): ?>
                <?php foreach ($data['vinhos'] as $vinho): ?>
                    <div class="card-vinho" style="opacity: 0.85;">
                        <div>
                            <h3><?= htmlspecialchars($vinho['nome']) ?></h3>
                            <p><strong>Região:</strong> <?= htmlspecialchars($vinho['regiao'] ?? 'Não especificada') ?></p>
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($vinho['tipo'] ?? 'Não especificado') ?></p>
                        </div>
                        <div class="card-actions">
                            <a href="<?= BASE_URL ?>vinhos/restaurar/<?= $vinho['id'] ?>" class="btn btn-primary" style="background-color: #28a745;">Restaurar</a>
                            <a href="<?= BASE_URL ?>vinhos/destruir/<?= $vinho['id'] ?>" class="btn btn-danger" onclick="return confirm('ATENÇÃO: Esta ação é irreversível. Eliminar definitivamente?');">Eliminar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>A lixeira está vazia.</p>
            <?php endif; ?>
        </div>

        <br>
        <a href="<?= BASE_URL ?>" class="btn btn-secondary">Voltar ao Catálogo</a>
    </div>

</body>
</html>