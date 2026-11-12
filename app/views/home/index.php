<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adega Digital - Catálogo de Vinhos</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css?v=2">
</head>
<body>

    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <!-- Mensagens de feedback -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['tipo'] ?>">
                <?= $_SESSION['flash']['texto'] ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- Cabeçalho Editorial da Página -->
        <div class="page-hero">
            <div>
                <?php if (!empty($data['favoritos_selecionado'])): ?>
                    <span class="eyebrow">A sua seleção</span>
                    <h2>Vinhos favoritos</h2>
                    <p>Os vinhos que guardou para encontrar mais depressa.</p>
                <?php else: ?>
                    <span class="eyebrow">Explore a coleção</span>
                    <h2>O catálogo</h2>
                    <p>Pesquise e organize os vinhos da coleção por nome, região ou tipo.</p>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= BASE_URL ?>vinhos/criar" class="btn btn-primary">Adicionar vinho</a>
            <?php endif; ?>
        </div>

        <!-- Barra de Pesquisa e Filtros -->
        <form method="GET" action="<?= BASE_URL ?>" class="filters-bar">
            <?php if (!empty($data['favoritos_selecionado'])): ?>
                <input type="hidden" name="favoritos" value="1">
            <?php endif; ?>

            <div class="filter-field">
                <label for="q">Pesquisar por nome</label>
                <input type="text" id="q" name="q" placeholder="Ex.: Esporão Reserva" value="<?= htmlspecialchars($data['pesquisa']) ?>">
            </div>

            <div class="filter-field">
                <label for="regiao_id">Região</label>
                <select id="regiao_id" name="regiao_id">
                    <option value="">Todas</option>
                    <?php foreach ($data['regioes'] as $regiao): ?>
                        <option value="<?= $regiao['id'] ?>" <?= $data['regiao_selecionada'] == $regiao['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($regiao['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-field">
                <label for="tipo_id">Tipo</label>
                <select id="tipo_id" name="tipo_id">
                    <option value="">Todos</option>
                    <?php foreach ($data['tipos'] as $tipo): ?>
                        <option value="<?= $tipo['id'] ?>" <?= $data['tipo_selecionado'] == $tipo['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo['tipo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-field">
                <label for="ordem">Ordenar por</label>
                <select id="ordem" name="ordem">
                    <option value="nome_asc" <?= $data['ordem_selecionada'] == 'nome_asc' ? 'selected' : '' ?>>Nome (A-Z)</option>
                    <option value="nome_desc" <?= $data['ordem_selecionada'] == 'nome_desc' ? 'selected' : '' ?>>Nome (Z-A)</option>
                    <option value="regiao_asc" <?= $data['ordem_selecionada'] == 'regiao_asc' ? 'selected' : '' ?>>Região (A-Z)</option>
                    <option value="tipo_asc" <?= $data['ordem_selecionada'] == 'tipo_asc' ? 'selected' : '' ?>>Tipo (A-Z)</option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                <a href="<?= !empty($data['favoritos_selecionado']) ? BASE_URL . '?favoritos=1' : BASE_URL ?>" class="btn btn-secondary">Limpar</a>
            </div>
        </form>

        <!-- Metadados dos resultados -->
        <div class="results-meta">
            <span><strong><?= $data['total_vinhos'] ?? count($data['vinhos']) ?></strong> vinhos encontrados</span>
            <span>A mostrar até 6 por página</span>
        </div>

        <!-- Grelha de Cartões ou Estado Vazio -->
        <?php if (!empty($data['vinhos'])): ?>
            <div class="grid-vinhos">
                <?php foreach ($data['vinhos'] as $vinho): ?>
                    <div class="card-vinho">
                        <div>
                            <div class="card-top">
                                <span class="badge-tipo"><?= htmlspecialchars($vinho['tipo'] ?? 'Sem tipo') ?></span>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?= BASE_URL ?>vinhos/favorito/<?= $vinho['id'] ?>" 
                                       class="btn-star <?= !empty($vinho['favorito']) ? 'ativo' : '' ?>" 
                                       title="Alternar Favorito">
                                        <?= !empty($vinho['favorito']) ? '★' : '☆' ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <h3><?= htmlspecialchars($vinho['nome']) ?></h3>
                            <p class="card-regiao"><strong>Região</strong> · <?= htmlspecialchars($vinho['regiao'] ?? 'Não especificada') ?></p>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="card-actions">
                                <a href="<?= BASE_URL ?>vinhos/editar/<?= $vinho['id'] ?>" class="btn btn-warning">Editar</a>
                                <a href="<?= BASE_URL ?>vinhos/apagar/<?= $vinho['id'] ?>" class="btn btn-danger" onclick="return confirm('Mover este vinho para a lixeira?');">Mover para a lixeira</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <?php if (!empty($data['favoritos_selecionado'])): ?>
                    <h3>Ainda não tem favoritos</h3>
                    <p>Use a estrela num vinho do catálogo para o guardar aqui.</p>
                    <a href="<?= BASE_URL ?>" class="btn btn-secondary">Ver catálogo completo</a>
                <?php else: ?>
                    <h3>Nenhum vinho encontrado</h3>
                    <p>Tente ajustar os filtros ou limpar a pesquisa atual.</p>
                    <a href="<?= BASE_URL ?>" class="btn btn-secondary">Limpar filtros</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Paginação -->
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
                    <?php $params = $_GET; $params['pagina'] = $data['pagina_atual'] - 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link">Anterior</a>
                <?php endif; ?>

                <?php for ($i = $inicio; $i <= $fim; $i++): ?>
                    <?php $params = $_GET; $params['pagina'] = $i; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link <?= $i == $data['pagina_atual'] ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($data['pagina_atual'] < $data['total_paginas']): ?>
                    <?php $params = $_GET; $params['pagina'] = $data['pagina_atual'] + 1; ?>
                    <a href="<?= BASE_URL ?>?<?= http_build_query($params) ?>" class="page-link">Próxima</a>
                <?php endif; ?>
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