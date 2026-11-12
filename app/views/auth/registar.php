<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Adega Digital</title>
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

        <div class="form-card">
            <h2>Criar Conta</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                Regista um novo utilizador para gerir a adega.
            </p>

            <form method="POST" action="<?= BASE_URL ?>auth/registar" autocomplete="off">
                <div class="form-group">
                    <label for="username">Nome de Utilizador</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Palavra-passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirmar_password">Confirmar Palavra-passe</label>
                    <input type="password" id="confirmar_password" name="confirmar_password" required>
                </div>

                <div style="display: flex; gap: 0.8rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Criar Conta</button>
                    <a href="<?= BASE_URL ?>auth/login" class="btn btn-secondary">Voltar ao Login</a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 - Trabalho Prático de Programação Web</p>
    </footer>

</body>
</html>