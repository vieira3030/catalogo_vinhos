USE catalogo_vinhos;

-- Tabela de Regiões Vitivinícolas
CREATE TABLE IF NOT EXISTS regioes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE
);

-- Tabela de Tipos de Vinho
CREATE TABLE IF NOT EXISTS tipos_vinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL UNIQUE
);