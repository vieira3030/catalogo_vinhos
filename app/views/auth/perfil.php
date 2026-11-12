<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Minha Conta - Adega Digital</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css?v=2">
</head>
<body>

    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <div class="form-card">
            <h2>👤 A Minha Conta</h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                Sessão iniciada como <strong><?= htmlspecialchars($data['username']) ?></strong>.
            </p>

            <div style="background: #fcfbfa; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.2rem; margin-bottom: 2rem;">
                <p style="margin-bottom: 0.5rem;"><strong>Vinhos adicionados por ti:</strong> <?= $data['stats']['vinhos'] ?></p>
                <p><strong>Os teus vinhos favoritos:</strong> <?= $data['stats']['favoritos'] ?></p>
            </div>

            <div style="display: flex; gap: 0.8rem;">
                <a href="<?= BASE_URL ?>auth/logout" 
                   class="btn btn-danger" 
                   style="padding: 0.75rem 1.4rem; font-size: 0.9rem;"
                   onclick="return confirm('Tens a certeza que queres terminar sessão?');">
                   Terminar Sessão
                </a>
                <a href="<?= BASE_URL ?>" class="btn btn-secondary">Voltar ao Catálogo</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 - Trabalho Prático de Programação Web</p>
    </footer>

</body>
</html>