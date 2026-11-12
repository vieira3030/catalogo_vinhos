<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessão - Adega Digital</title>
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
            <h2>Iniciar Sessão</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                Autentica-te para gerir a remoção de vinhos e aceder à lixeira.
            </p>

            <form method="POST" action="<?= BASE_URL ?>auth/login" autocomplete="off">
                <div class="form-group">
                    <label for="username">Utilizador</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Palavra-passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div style="display: flex; gap: 0.8rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                    <a href="<?= BASE_URL ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>

            <p style="margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
                Ainda não tens conta? <a href="<?= BASE_URL ?>auth/registar" style="color: var(--burgundy-main); font-weight: 600;">Criar conta</a>
            </p>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 - Trabalho Prático de Programação Web</p>
    </footer>

</body>
</html>