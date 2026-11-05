<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Vinho - Adega Digital</title>
    <!-- Carregamento dos estilos CSS principais -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>

    <!-- Cabeçalho principal com navegação -->
    <header>
        <div class="header-content">
            <h1>🍷 Adega Digital</h1>
            <nav>
                <a href="<?= BASE_URL ?>">Início</a>
                <!-- Link de acesso à Lixeira -->
                <a href="<?= BASE_URL ?>vinhos/lixeira">🗑️ Lixeira</a>
                <a href="<?= BASE_URL ?>autores">Autores</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="form-card">
            <h2>Adicionar Novo Vinho</h2>
            
            <!-- Formulário de envio dos dados do vinho -->
            <form action="<?= BASE_URL ?>vinhos/guardar" method="POST">
                
                <!-- Nome obrigatório do vinho -->
                <div class="form-group">
                    <label for="nome">Nome do Vinho *</label>
                    <input type="text" id="nome" name="nome" required placeholder="Ex: Esporão Reserva">
                </div>

                <!-- Seleção de região existente ou inserção manual de nova região -->
                <div class="form-group">
                    <label for="regiao_id">Região / País</label>
                    <select id="regiao_id" name="regiao_id">
                        <option value="">-- Selecione da lista --</option>
                        <?php foreach ($data['regioes'] as $regiao): ?>
                            <option value="<?= $regiao['id'] ?>"><?= htmlspecialchars($regiao['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Campo opcional para escrever uma região não existente na lista -->
                    <input type="text" name="nova_regiao" placeholder="Ou escreve uma nova região..." style="margin-top: 0.5rem;">
                </div>

                <!-- Seleção de tipo existente ou inserção manual de novo tipo -->
                <div class="form-group">
                    <label for="tipo_id">Tipo de Vinho</label>
                    <select id="tipo_id" name="tipo_id">
                        <option value="">-- Selecione da lista --</option>
                        <?php foreach ($data['tipos'] as $tipo): ?>
                            <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['tipo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Campo opcional para escrever um tipo não existente na lista -->
                    <input type="text" name="novo_tipo" placeholder="Ou escreve um novo tipo (ex: Rosé)..." style="margin-top: 0.5rem;">
                </div>

                <!-- Botões de submissão e cancelamento -->
                <button type="submit" class="btn btn-primary">Guardar Vinho</button>
                <a href="<?= BASE_URL ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

</body>
</html>