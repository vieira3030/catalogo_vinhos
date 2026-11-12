<?php
// Identificar a página atual para ocultar o link ativo na navegação
$urlAtual = trim($_GET['url'] ?? '', '/');
$emFavoritos = ($urlAtual === '' && !empty($_GET['favoritos']));
$emInicio = ($urlAtual === '' && !$emFavoritos);
$logado = isset($_SESSION['user_id']);
?>

<header>
    <div class="header-content">
        <!-- Logótipo tipográfico com monograma -->
        <a href="<?= BASE_URL ?>" class="brand">
            <div class="brand-monogram">AD</div>
            <div class="brand-text">
                <h1>Adega Digital</h1>
                <span>Catálogo de Vinhos</span>
            </div>
        </a>

        <!-- Navegação condicional -->
        <nav>
            <?php if (!$emInicio): ?>
                <a href="<?= BASE_URL ?>">Catálogo</a>
            <?php endif; ?>

            <?php if ($logado): ?>
                <?php if (!$emFavoritos): ?>
                    <a href="<?= BASE_URL ?>?favoritos=1">Favoritos</a>
                <?php endif; ?>

                <?php if ($urlAtual !== 'vinhos/lixeira'): ?>
                    <a href="<?= BASE_URL ?>vinhos/lixeira">Lixeira</a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($urlAtual !== 'autores'): ?>
                <a href="<?= BASE_URL ?>autores">Projeto e API</a>
            <?php endif; ?>

            <?php if ($logado): ?>
                <?php if ($urlAtual !== 'auth/perfil'): ?>
                    <a href="<?= BASE_URL ?>auth/perfil">Conta (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
                <?php endif; ?>
            <?php else: ?>
                <?php if ($urlAtual !== 'auth/login'): ?>
                    <a href="<?= BASE_URL ?>auth/login">Entrar</a>
                <?php endif; ?>
                <?php if ($urlAtual !== 'auth/registar'): ?>
                    <a href="<?= BASE_URL ?>auth/registar">Criar Conta</a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>
</header>