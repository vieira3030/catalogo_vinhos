<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adega Digital - Catálogo de Vinhos</title>
    <!-- Carregamento do CSS -->
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
        <h2>Catálogo de Vinhos</h2>

        <!-- Formulário de Filtros e Pesquisa -->
        <form method="GET" action="<?= BASE_URL ?>" class="filters-bar">
            <input type="text" name="q" placeholder="Pesquisar por nome..." value="<?= htmlspecialchars($data['pesquisa']) ?>">
            
            <select name="regiao_id">
                <option value="">Todas as Regiões</option>
                <?php foreach ($data['regioes'] as $regiao): ?>
                    <option value="<?= $regiao['id'] ?>" <?= $data['regiao_selecionada'] == $regiao['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($regiao['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="tipo_id">
                <option value="">Todos os Tipos</option>
                <?php foreach ($data['tipos'] as $tipo): ?>
                    <option value="<?= $tipo['id'] ?>" <?= $data['tipo_selecionado'] == $tipo['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tipo['tipo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="<?= BASE_URL ?>" class="btn btn-secondary">Limpar</a>
        </form>

        <!-- Lista de Vinhos (6 por página) -->
        <div class="grid-vinhos">
            <?php if (!empty($data['vinhos'])): ?>
                <?php foreach ($data['vinhos'] as $vinho): ?>
                    <div class="card-vinho">
                        <div>
                            <h3><?= htmlspecialchars($vinho['nome']) ?></h3>
                            <p><strong>Região:</strong> <?= htmlspecialchars($vinho['regiao'] ?? 'Não especificada') ?></p>
                            <p><strong>Tipo:</strong> <?= htmlspecialchars($vinho['tipo'] ?? 'Não especificado') ?></p>
                        </div>
                        <div class="card-actions">
                            <a href="<?= BASE_URL ?>vinhos/editar/<?= $vinho['id'] ?>" class="btn btn-warning">Editar</a>
                            <a href="<?= BASE_URL ?>vinhos/apagar/<?= $vinho['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem a certeza que deseja mover este vinho para a lixeira?');">Apagar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum vinho encontrado com os critérios selecionados.</p>
            <?php endif; ?>
        </div>

       <!-- Controlo de Paginação Compacta (máximo 4 números visíveis de cada vez) -->
        <?php if ($data['total_paginas'] > 1): ?>
            <?php
                // Definir limite de 4 números visíveis na barra
                $max_visiveis = 4;

                // Calcular o intervalo inicial e final com base na página atual
                $inicio = max(1, $data['pagina_atual'] - 1);
                $fim = min($data['total_paginas'], $inicio + ($max_visiveis - 1));

                // Ajustar o início caso esteja próximo do final para manter sempre 4 números
                if ($fim - $inicio + 1 < $max_visiveis) {
                    $inicio = max(1, $fim - ($max_visiveis - 1));
                }
            ?>

            <div class="pagination">
                <!-- Botão para a Primeira Página -->
                <?php if ($data['pagina_atual'] > 1): ?>
                    <?php $params = $_GET; $params['pagina'] = 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link" title="Primeira Página">&laquo;&laquo;</a>
                <?php endif; ?>

                <!-- Botão Página Anterior -->
                <?php if ($data['pagina_atual'] > 1): ?>
                    <?php $params = $_GET; $params['pagina'] = $data['pagina_atual'] - 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link">&laquo; Anterior</a>
                <?php endif; ?>

                <!-- Números Dinâmicos das Páginas (exibe apenas o intervalo de 4 páginas) -->
                <?php for ($i = $inicio; $i <= $fim; $i++): ?>
                    <?php $params = $_GET; $params['pagina'] = $i; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link <?= $i == $data['pagina_atual'] ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <!-- Botão Próxima Página -->
                <?php if ($data['pagina_atual'] < $data['total_paginas']): ?>
                    <?php $params = $_GET; $params['pagina'] = $data['pagina_atual'] + 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link">Próximo &raquo;</a>
                <?php endif; ?>

                <!-- Botão para a Última Página -->
                <?php if ($data['pagina_atual'] < $data['total_paginas']): ?>
                    <?php $params = $_GET; $params['pagina'] = $data['total_paginas']; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link" title="Última Página">&raquo;&raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2026 - Trabalho Prático de Programação Web</p>
    </footer>

</body>
</html>