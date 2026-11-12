<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre o Projeto - Adega Digital</title>
    <!-- Estilos CSS principais -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css?v=2">
</head>
<body>

    <!-- Cabeçalho dinâmico partilhado -->
    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <div class="page-hero">
            <div>
                <span class="eyebrow">Quem está por trás</span>
                <h2>Sobre o projeto</h2>
            </div>
        </div>

        <!-- Cartão de identificação académica e autores -->
        <div class="about-card">
            <h3>Trabalho Prático · Programação Web</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Engenharia da Computação Gráfica e Multimédia · ESTG / UNIPVC · 2026</p>

            <div class="authors-list">
                <span class="author-pill">Rodrigo Vieira</span>
                <span class="author-pill">André Flores</span>
                <span class="author-pill">Rodrigo Malheiro</span>
            </div>
        </div>

        <!-- Secção de documentação dos 4 endpoints da API REST -->
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.45rem; margin-bottom: 0.25rem;">API REST</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Endpoints de leitura que devolvem os dados em formato JSON.</p>

        <div class="api-grid">
            <!-- Endpoint 1: Lista de vinhos -->
            <div class="api-card">
                <p style="margin-bottom: 0.5rem;"><span class="method-badge">GET</span><code>/api/vinhos</code></p>
                <p style="color: var(--text-muted); font-size: 0.86rem; margin-bottom: 1rem;">Lista os vinhos ativos no catálogo.</p>
                <a href="<?= BASE_URL ?>api/vinhos" target="_blank" class="btn btn-secondary">Abrir endpoint</a>
            </div>

            <!-- Endpoint 2: Detalhe de um vinho -->
            <div class="api-card">
                <p style="margin-bottom: 0.5rem;"><span class="method-badge">GET</span><code>/api/vinhos/{id}</code></p>
                <p style="color: var(--text-muted); font-size: 0.86rem; margin-bottom: 1rem;">Consulta os dados de um vinho pelo identificador.</p>
                <a href="<?= BASE_URL ?>api/vinhos/1" target="_blank" class="btn btn-secondary">Testar com ID 1</a>
            </div>

            <!-- Endpoint 3: Lista de regiões -->
            <div class="api-card">
                <p style="margin-bottom: 0.5rem;"><span class="method-badge">GET</span><code>/api/regioes</code></p>
                <p style="color: var(--text-muted); font-size: 0.86rem; margin-bottom: 1rem;">Lista todas as regiões vitivinícolas registadas.</p>
                <a href="<?= BASE_URL ?>api/regioes" target="_blank" class="btn btn-secondary">Abrir endpoint</a>
            </div>

            <!-- Endpoint 4: Lista de tipos de vinho -->
            <div class="api-card">
                <p style="margin-bottom: 0.5rem;"><span class="method-badge">GET</span><code>/api/tipos</code></p>
                <p style="color: var(--text-muted); font-size: 0.86rem; margin-bottom: 1rem;">Lista todos os tipos de vinho disponíveis.</p>
                <a href="<?= BASE_URL ?>api/tipos" target="_blank" class="btn btn-secondary">Abrir endpoint</a>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer>
        <div class="footer-content">
            <strong>Adega Digital</strong>
            <span>Trabalho Prático · Programação Web · 2026</span>
        </div>
    </footer>

</body>
</html>