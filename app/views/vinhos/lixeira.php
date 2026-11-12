<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lixeira - Adega Digital</title>
   <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css?v=2">
</head>
<body>

    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['tipo'] ?>">
                <?= $_SESSION['flash']['texto'] ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="page-hero">
            <div>
                <span class="eyebrow">Gestão da coleção</span>
                <h2>Lixeira</h2>
                <p>Os vinhos nesta lista já não aparecem no catálogo. Pode restaurá-los ou eliminá-los permanentemente.</p>
            </div>
            <a href="<?= BASE_URL ?>" class="btn btn-secondary">Voltar ao catálogo</a>
        </div>

        <div class="results-meta">
            <span><strong><?= count($data['vinhos']) ?></strong> vinhos na lixeira</span>
        </div>

        <?php if (!empty($data['vinhos'])): ?>
            <div class="grid-vinhos">
                <?php foreach ($data['vinhos'] as $vinho): ?>
                    <div class="card-vinho">
                        <div>
                            <div class="card-top">
                                <span class="badge-tipo"><?= htmlspecialchars($vinho['tipo'] ?? 'Sem tipo') ?></span>
                            </div>
                            <h3><?= htmlspecialchars($vinho['nome']) ?></h3>
                            <p class="card-regiao"><strong>Região</strong> · <?= htmlspecialchars($vinho['regiao'] ?? 'Não especificada') ?></p>
                        </div>

                        <div class="card-actions">
                            <a href="<?= BASE_URL ?>vinhos/restaurar/<?= $vinho['id'] ?>" class="btn btn-warning">Restaurar</a>
                            <a href="<?= BASE_URL ?>vinhos/destruir/<?= $vinho['id'] ?>" class="btn btn-danger" onclick="return confirm('Eliminar definitivamente este vinho?');">Eliminar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>A lixeira está vazia</h3>
                <p>Quando remover um vinho, poderá restaurá-lo a partir daqui.</p>
                <a href="<?= BASE_URL ?>" class="btn btn-secondary">Ver catálogo</a>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <div class="footer-content">
            <strong>Adega Digital</strong>
            <span>Trabalho Prático · Programação Web · 2026</span>
        </div>
    </footer>

</body>
</html>