<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lixeira de Vinhos - Adega Digital</title>
    <!-- Estilos CSS principais -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>

    <!-- Cabeçalho principal -->
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
        <!-- Exibição de Mensagens Flash de Feedback (Restauro / Remoção) -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['tipo'] ?>">
                <?= $_SESSION['flash']['texto'] ?>
            </div>
            <!-- Limpar a mensagem da sessão após exibição -->
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <h2 class="page-title">🗑️ Lixeira de Vinhos</h2>
        <p style="margin-bottom: 2rem; color: var(--text-muted);">Estes vinhos foram removidos do catálogo. Podes restaurá-los ou eliminá-los definitivamente.</p>

        <!-- Grelha de Vinhos Removidos -->
        <div class="grid-vinhos">
            <?php if (!empty($data['vinhos'])): ?>
                <?php foreach ($data['vinhos'] as $vinho): ?>
                    <div class="card-vinho" style="opacity: 0.85;">
                        <div>
                            <h3><?= htmlspecialchars($vinho['nome']) ?></h3>
                            <p><strong>Região:</strong> <?= htmlspecialchars($vinho['regiao'] ?? 'Não especificada') ?></p>
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($vinho['tipo'] ?? 'Não especificado') ?></p>
                        </div>
                        <div class="card-actions">
                            <a href="<?= BASE_URL ?>vinhos/restaurar/<?= $vinho['id'] ?>" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Restaurar</a>
                            <a href="<?= BASE_URL ?>vinhos/destruir/<?= $vinho['id'] ?>" class="btn btn-danger" onclick="return confirm('ATENÇÃO: Esta ação é irreversível. Eliminar definitivamente?');">Eliminar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>A lixeira está vazia.</p>
            <?php endif; ?>
        </div>

        <div style="margin-top: 2.5rem;">
            <a href="<?= BASE_URL ?>" class="btn btn-secondary">Voltar ao Catálogo</a>
        </div>
    </div>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2026 - Trabalho Prático de Programação Web</p>
    </footer>

</body>
</html>