<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vinho - Adega Digital</title>
    <!-- Estilos CSS principais -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css?v=2">
</head>
<body>

    <!-- Cabeçalho dinâmico partilhado -->
    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <div class="form-card">
            <h2>Editar Vinho</h2>

            <!-- Formulário de edição com suporte a seleção ou criação de nova região/tipo -->
            <form method="POST" action="<?= BASE_URL ?>vinhos/atualizar/<?= $data['vinho']['id'] ?>">
                
                <!-- Nome do vinho -->
                <div class="form-group">
                    <label for="nome">Nome do Vinho *</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($data['vinho']['nome']) ?>" required>
                </div>

                <!-- Região existente ou nova região -->
                <div class="form-group">
                    <label for="regiao_id">Região / País</label>
                    <select id="regiao_id" name="regiao_id" style="margin-bottom: 0.6rem;">
                        <option value="">-- Selecione da lista --</option>
                        <?php foreach ($data['regioes'] as $regiao): ?>
                            <option value="<?= $regiao['id'] ?>" <?= $data['vinho']['regiao_id'] == $regiao['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($regiao['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" 
                           name="nova_regiao" 
                           value="<?= !empty($data['vinho']['regiao_pers']) ? htmlspecialchars($data['vinho']['regiao_nome']) : '' ?>" 
                           placeholder="Ou escreve uma nova região...">
                </div>

                <!-- Tipo existente ou novo tipo -->
                <div class="form-group">
                    <label for="tipo_id">Tipo de Vinho</label>
                    <select id="tipo_id" name="tipo_id" style="margin-bottom: 0.6rem;">
                        <option value="">-- Selecione da lista --</option>
                        <?php foreach ($data['tipos'] as $tipo): ?>
                            <option value="<?= $tipo['id'] ?>" <?= $data['vinho']['tipo_id'] == $tipo['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tipo['tipo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" 
                           name="novo_tipo" 
                           value="<?= !empty($data['vinho']['tipo_pers']) ? htmlspecialchars($data['vinho']['tipo_nome']) : '' ?>" 
                           placeholder="Ou escreve um novo tipo (ex: Rosé)...">
                </div>

                <!-- Botões de submissão e cancelamento -->
                <div style="display: flex; gap: 0.8rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Atualizar Vinho</button>
                    <a href="<?= BASE_URL ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2026 - Trabalho Prático de Programação Web</p>
    </footer>

<script>
        // Sincronizar lista e campo de texto livre para evitar conflitos
        const regiaoSelect = document.getElementById('regiao_id');
        const novaRegiaoInput = document.querySelector('input[name="nova_regiao"]');
        const tipoSelect = document.getElementById('tipo_id');
        const novoTipoInput = document.querySelector('input[name="novo_tipo"]');

        // Ao escolher na lista, limpa o texto personalizado
        regiaoSelect.addEventListener('change', () => {
            if (regiaoSelect.value !== '') novaRegiaoInput.value = '';
        });
        tipoSelect.addEventListener('change', () => {
            if (tipoSelect.value !== '') novoTipoInput.value = '';
        });

        // Ao escrever um texto novo, repõe a lista para "-- Selecione da lista --"
        novaRegiaoInput.addEventListener('input', () => {
            if (novaRegiaoInput.value.trim() !== '') regiaoSelect.value = '';
        });
        novoTipoInput.addEventListener('input', () => {
            if (novoTipoInput.value.trim() !== '') tipoSelect.value = '';
        });
    </script>
</body>

</html>