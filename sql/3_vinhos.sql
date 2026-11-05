USE catalogo_vinhos;

-- Tabela principal de Vinhos com suporte a Soft Delete (coluna ativo)
CREATE TABLE IF NOT EXISTS vinhos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    regiao_id INT,
    tipo_id INT,
    ativo TINYINT DEFAULT 1,
    FOREIGN KEY (regiao_id) REFERENCES regioes(id) ON DELETE SET NULL,
    FOREIGN KEY (tipo_id) REFERENCES tipos_vinho(id) ON DELETE SET NULL
);

-- Inserção inicial das regiões vitivinícolas
INSERT INTO regioes (nome) VALUES 
('Vinho Verde'), ('Trás-os-Montes'), ('Douro'), ('Távora-Varosa'), 
('Dão'), ('Lafões'), ('Bairrada'), ('Beira Interior'), 
('Lisboa'), ('Tejo'), ('Península de Setúbal'), ('Alentejo'), 
('Algarve'), ('Madeira'), ('Açores')
ON DUPLICATE KEY UPDATE nome=VALUES(nome);

-- Inserção inicial dos tipos de vinho
INSERT INTO tipos_vinho (tipo) VALUES 
('Branco'), ('Tinto'), ('Rosé'), ('Tinto/Branco'), 
('Espumante'), ('Fortificado'), ('Licoroso')
ON DUPLICATE KEY UPDATE tipo=VALUES(tipo);

-- Inserção de todo o catálogo de vinhos mapeado por subconsultas
INSERT INTO vinhos (nome, regiao_id, tipo_id, ativo) VALUES
-- Vinho Verde
('Vinho Verde Alvarinho', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Vinho Verde Loureiro', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Vinho Verde Trajadura', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Vinho Verde Avesso', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Vinho Verde Arinto', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Vinho Verde Tinto', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Vinho Verde Rosé', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Monção e Melgaço Alvarinho', (SELECT id FROM regioes WHERE nome = 'Vinho Verde' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),

-- Trás-os-Montes
('Trás-os-Montes Tinto', (SELECT id FROM regioes WHERE nome = 'Trás-os-Montes' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Trás-os-Montes Branco', (SELECT id FROM regioes WHERE nome = 'Trás-os-Montes' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Trás-os-Montes Rosé', (SELECT id FROM regioes WHERE nome = 'Trás-os-Montes' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Chaves', (SELECT id FROM regioes WHERE nome = 'Trás-os-Montes' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Valpaços', (SELECT id FROM regioes WHERE nome = 'Trás-os-Montes' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Planalto Mirandês', (SELECT id FROM regioes WHERE nome = 'Trás-os-Montes' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),

-- Douro
('Douro Tinto', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Douro Branco', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Douro Rosé', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Douro Espumante', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Espumante' LIMIT 1), 1),
('Porto Ruby', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Ruby Reserva', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Tawny', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Tawny 10 Anos', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Tawny 20 Anos', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Tawny 30 Anos', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Tawny 40 Anos', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Vintage', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Late Bottled Vintage (LBV)', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Colheita', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Branco', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Porto Rosé', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Moscatel do Douro', (SELECT id FROM regioes WHERE nome = 'Douro' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Licoroso' LIMIT 1), 1),

-- Távora-Varosa
('Távora-Varosa Branco', (SELECT id FROM regioes WHERE nome = 'Távora-Varosa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Távora-Varosa Tinto', (SELECT id FROM regioes WHERE nome = 'Távora-Varosa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Távora-Varosa Rosé', (SELECT id FROM regioes WHERE nome = 'Távora-Varosa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Távora-Varosa Espumante', (SELECT id FROM regioes WHERE nome = 'Távora-Varosa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Espumante' LIMIT 1), 1),

-- Dão
('Dão Tinto', (SELECT id FROM regioes WHERE nome = 'Dão' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Dão Branco', (SELECT id FROM regioes WHERE nome = 'Dão' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Dão Rosé', (SELECT id FROM regioes WHERE nome = 'Dão' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Dão Espumante', (SELECT id FROM regioes WHERE nome = 'Dão' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Espumante' LIMIT 1), 1),
('Dão Encruzado', (SELECT id FROM regioes WHERE nome = 'Dão' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Dão Touriga Nacional', (SELECT id FROM regioes WHERE nome = 'Dão' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),

-- Lafões
('Lafões Tinto', (SELECT id FROM regioes WHERE nome = 'Lafões' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Lafões Branco', (SELECT id FROM regioes WHERE nome = 'Lafões' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),

-- Bairrada
('Bairrada Tinto', (SELECT id FROM regioes WHERE nome = 'Bairrada' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Bairrada Branco', (SELECT id FROM regioes WHERE nome = 'Bairrada' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Bairrada Rosé', (SELECT id FROM regioes WHERE nome = 'Bairrada' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Bairrada Espumante', (SELECT id FROM regioes WHERE nome = 'Bairrada' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Espumante' LIMIT 1), 1),
('Bairrada Baga', (SELECT id FROM regioes WHERE nome = 'Bairrada' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Bairrada Clássico', (SELECT id FROM regioes WHERE nome = 'Bairrada' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),

-- Beira Interior
('Beira Interior Tinto', (SELECT id FROM regioes WHERE nome = 'Beira Interior' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Beira Interior Branco', (SELECT id FROM regioes WHERE nome = 'Beira Interior' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Beira Interior Rosé', (SELECT id FROM regioes WHERE nome = 'Beira Interior' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Beira Interior Espumante', (SELECT id FROM regioes WHERE nome = 'Beira Interior' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Espumante' LIMIT 1), 1),
('Castelo Rodrigo', (SELECT id FROM regioes WHERE nome = 'Beira Interior' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Cova da Beira', (SELECT id FROM regioes WHERE nome = 'Beira Interior' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Pinhel', (SELECT id FROM regioes WHERE nome = 'Beira Interior' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),

-- Lisboa
('Bucelas', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Colares Tinto', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Colares Branco', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Carcavelos', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Licoroso' LIMIT 1), 1),
('Óbidos Tinto', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Óbidos Branco', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Alenquer Tinto', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Alenquer Branco', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Arruda Tinto', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Arruda Branco', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Torres Vedras Tinto', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Torres Vedras Branco', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Encostas d''Aire Tinto', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Encostas d''Aire Branco', (SELECT id FROM regioes WHERE nome = 'Lisboa' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),

-- Tejo
('Tejo Tinto', (SELECT id FROM regioes WHERE nome = 'Tejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Tejo Branco', (SELECT id FROM regioes WHERE nome = 'Tejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Tejo Rosé', (SELECT id FROM regioes WHERE nome = 'Tejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Tejo Espumante', (SELECT id FROM regioes WHERE nome = 'Tejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Espumante' LIMIT 1), 1),

-- Península de Setúbal
('Palmela Tinto', (SELECT id FROM regioes WHERE nome = 'Península de Setúbal' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Palmela Branco', (SELECT id FROM regioes WHERE nome = 'Península de Setúbal' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Palmela Rosé', (SELECT id FROM regioes WHERE nome = 'Península de Setúbal' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Moscatel de Setúbal', (SELECT id FROM regioes WHERE nome = 'Península de Setúbal' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Licoroso' LIMIT 1), 1),
('Moscatel Roxo de Setúbal', (SELECT id FROM regioes WHERE nome = 'Península de Setúbal' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Licoroso' LIMIT 1), 1),
('Península de Setúbal Tinto', (SELECT id FROM regioes WHERE nome = 'Península de Setúbal' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Península de Setúbal Branco', (SELECT id FROM regioes WHERE nome = 'Península de Setúbal' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),

-- Alentejo
('Alentejo Tinto', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Alentejo Branco', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Alentejo Rosé', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),
('Alentejo Espumante', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Espumante' LIMIT 1), 1),
('Borba', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Évora', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Granja-Amareleja', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Moura', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Portalegre', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Redondo', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Reguengos', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Vidigueira', (SELECT id FROM regioes WHERE nome = 'Alentejo' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),

-- Algarve
('Lagoa', (SELECT id FROM regioes WHERE nome = 'Algarve' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Lagos', (SELECT id FROM regioes WHERE nome = 'Algarve' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Portimão', (SELECT id FROM regioes WHERE nome = 'Algarve' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Tavira', (SELECT id FROM regioes WHERE nome = 'Algarve' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto/Branco' LIMIT 1), 1),
('Algarve Rosé', (SELECT id FROM regioes WHERE nome = 'Algarve' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),

-- Madeira
('Vinho Madeira Sercial', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Vinho Madeira Verdelho', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Vinho Madeira Boal', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Vinho Madeira Malvasia', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Vinho Madeira Terrantez', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Vinho Madeira Tinta Negra', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Madeira Rainwater', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Fortificado' LIMIT 1), 1),
('Madeirense Tinto', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Madeirense Branco', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Madeirense Rosé', (SELECT id FROM regioes WHERE nome = 'Madeira' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1),

-- Açores
('Pico Branco', (SELECT id FROM regioes WHERE nome = 'Açores' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Pico Tinto', (SELECT id FROM regioes WHERE nome = 'Açores' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Biscoitos', (SELECT id FROM regioes WHERE nome = 'Açores' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Licoroso' LIMIT 1), 1),
('Graciosa', (SELECT id FROM regioes WHERE nome = 'Açores' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Açores Branco', (SELECT id FROM regioes WHERE nome = 'Açores' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Branco' LIMIT 1), 1),
('Açores Tinto', (SELECT id FROM regioes WHERE nome = 'Açores' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Tinto' LIMIT 1), 1),
('Açores Rosé', (SELECT id FROM regioes WHERE nome = 'Açores' LIMIT 1), (SELECT id FROM tipos_vinho WHERE tipo = 'Rosé' LIMIT 1), 1);