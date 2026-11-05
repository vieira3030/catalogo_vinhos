<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vinho - Adega Digital</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>

    <header>
        <div class="header-content">
            <h1>🍷 Adega Digital</h1>
            <nav>
                <a href="<?= BASE_URL ?>">Início</a>
                <a href="<?= BASE_URL ?>autores">Autores</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="form-card">
            <h2>Editar Vinho</h2>
            <form action="<?= BASE_URL ?>vinhos/atualizar" method="POST">
                <input type="hidden" name="id" value="<?= $data['vinho']['id'] ?>">

                <div class="form-group">
                    <label for="nome">Nome do Vinho *</label>
                    <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($data['vinho']['nome']) ?>">
                </div>

                <div class="form-group">
                    <label for="regiao_id">Região / País</label>
                    <select id="regiao_id" name="regiao_id">
                        <option value="">-- Selecione uma Região --</option>
                        <?php foreach ($data['regioes'] as $regiao): ?>
                            <option value="<?= $regiao['id'] ?>" <?= $data['vinho']['regiao_id'] == $regiao['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($regiao['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tipo_id">Tipo de Vinho</label>
                    <select id="tipo_id" name="tipo_id">
                        <option value="">-- Selecione um Tipo --</option>
                        <?php foreach ($data['tipos'] as $tipo): ?>
                            <option value="<?= $tipo['id'] ?>" <?= $data['vinho']['tipo_id'] == $tipo['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tipo['tipo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Vinho</button>
                <a href="<?= BASE_URL ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

</body>
</html>