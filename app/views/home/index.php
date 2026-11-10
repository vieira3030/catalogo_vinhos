<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adega Digital - Catálogo de Vinhos</title>
    <!-- Estilos CSS principais -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>

    <!-- Cabeçalho principal com navegação -->
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
        <!-- Exibição de mensagens flash de feedback -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['tipo'] ?>">
                <?= $_SESSION['flash']['texto'] ?>
            </div>
            <!-- Limpar mensagem após exibição -->
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <h2>Catálogo de Vinhos</h2>

        <!-- Formulário de Filtros, Pesquisa e Ordenação -->
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

            <!-- Seletor de Ordenação Sem "Mais Recentes" -->
            <select name="ordem">
                <option value="nome_asc" <?= $data['ordem_selecionada'] == 'nome_asc' ? 'selected' : '' ?>>Nome (A-Z)</option>
                <option value="nome_desc" <?= $data['ordem_selecionada'] == 'nome_desc' ? 'selected' : '' ?>>Nome (Z-A)</option>
                <option value="regiao_asc" <?= $data['ordem_selecionada'] == 'regiao_asc' ? 'selected' : '' ?>>Região (A-Z)</option>
                <option value="tipo_asc" <?= $data['ordem_selecionada'] == 'tipo_asc' ? 'selected' : '' ?>>Tipo (A-Z)</option>
            </select>

            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="<?= BASE_URL ?>" class="btn btn-secondary">Limpar</a>
        </form>

        <!-- Lista de Vinhos em grelha (6 por página) -->
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

        <!-- Controlo de Paginação Compacta -->
        <?php if ($data['total_paginas'] > 1): ?>
            <?php
                $max_visiveis = 4;
                $inicio = max(1, $data['pagina_atual'] - 1);
                $fim = min($data['total_paginas'], $inicio + ($max_visiveis - 1));

                if ($fim - $inicio + 1 < $max_visiveis) {
                    $inicio = max(1, $fim - ($max_visiveis - 1));
                }
            ?>

            <div class="pagination">
                <?php if ($data['pagina_atual'] > 1): ?>
                    <?php $params = $_GET; $params['pagina'] = 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link" title="Primeira Página">&laquo;&laquo;</a>
                    <?php $params['pagina'] = $data['pagina_atual'] - 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link">&laquo; Anterior</a>
                <?php endif; ?>

                <?php for ($i = $inicio; $i <= $fim; $i++): ?>
                    <?php $params = $_GET; $params['pagina'] = $i; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link <?= $i == $data['pagina_atual'] ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($data['pagina_atual'] < $data['total_paginas']): ?>
                    <?php $params = $_GET; $params['pagina'] = $data['pagina_atual'] + 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link">Próximo &raquo;</a>
                    <?php $params['pagina'] = $data['total_paginas']; ?>
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