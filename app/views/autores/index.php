<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores e API - Adega Digital</title>
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
                <a href="<?= BASE_URL ?>vinhos/lixeira">🗑️ Lixeira</a>
                <a href="<?= BASE_URL ?>autores">Autores</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2 class="page-title">👨‍💻 Autores do Projeto</h2>

        <!-- Cartão de Informação da Equipa e Disciplina -->
        <div class="form-card" style="max-width: 100%; margin-bottom: 3rem;">
            <h2>Trabalho Prático - Programação Web</h2>
            <p style="color: var(--text-muted); margin-bottom: 1rem;">
                Engenharia da Computação Gráfica e Multimédia — ESTG / UNIPVC (2026)
            </p>
            <ul style="list-style-type: square; padding-left: 1.2rem; line-height: 1.8;">
                <li><strong>Rodrigo Vieira</strong></li>
                <li><strong>André Flores</strong></li>
                <li><strong>Rodrigo Malheiro</strong></li>
            </ul>
        </div>

        <h2 class="page-title">🔌 Documentação da API REST (JSON)</h2>
        <p style="margin-bottom: 1.5rem; color: var(--text-muted);">
            A aplicação disponibiliza um serviço web interno que devolve os dados em formato JSON para integração externa.
        </p>

        <!-- Documentação dos Endpoints -->
        <div class="api-docs-grid">

            <!-- Endpoint 1: Listar Todos os Vinhos -->
            <div class="api-card">
                <div class="api-header">
                    <span class="method-badge get">GET</span>
                    <code>/api/vinhos</code>
                </div>
                <p>Devolve a lista completa de todos os vinhos ativos no catálogo em formato JSON.</p>
                <div class="api-actions">
                    <a href="<?= BASE_URL ?>api/vinhos" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Testar Endpoint 🔗</a>
                </div>
            </div>

            <!-- Endpoint 2: Obter Vinho por ID -->
            <div class="api-card">
                <div class="api-header">
                    <span class="method-badge get">GET</span>
                    <code>/api/vinhos/{id}</code>
                </div>
                <p>Devolve os detalhes de um vinho específico filtrado pelo seu identificador (ex: ID 1).</p>
                <div class="api-actions">
                    <a href="<?= BASE_URL ?>api/vinhos/1" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Testar ID 1 🔗</a>
                </div>
            </div>

            <!-- Endpoint 3: Listar Regiões Vitivinícolas -->
            <div class="api-card">
                <div class="api-header">
                    <span class="method-badge get">GET</span>
                    <code>/api/regioes</code>
                </div>
                <p>Devolve a lista de todas as regiões vitivinícolas registadas na base de dados.</p>
                <div class="api-actions">
                    <a href="<?= BASE_URL ?>api/regioes" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Testar Endpoint 🔗</a>
                </div>
            </div>

            <!-- Endpoint 4: Listar Tipos de Vinho -->
            <div class="api-card">
                <div class="api-header">
                    <span class="method-badge get">GET</span>
                    <code>/api/tipos</code>
                </div>
                <p>Devolve todos os tipos de vinho disponíveis (ex: Branco, Tinto, Espumante).</p>
                <div class="api-actions">
                    <a href="<?= BASE_URL ?>api/tipos" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">Testar Endpoint 🔗</a>
                </div>
            </div>

        </div>

    </div>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2026 - Trabalho Prático de Programação Web</p>
    </footer>

</body>
</html>