<?php
class Vinho {
    private $db;

    public function __construct() {
        // Conexão à base de dados MySQLi
        $this->db = (new Db())->conn;
    }

    // Listar vinhos ativos com suporte a paginação e filtros
    public function getPaginated($pesquisa = '', $regiao_id = '', $tipo_id = '', $limite = 6, $offset = 0) {
        $sql = "SELECT v.id, v.nome, r.nome AS regiao, t.tipo 
                FROM vinhos v
                LEFT JOIN regioes r ON v.regiao_id = r.id
                LEFT JOIN tipos_vinho t ON v.tipo_id = t.id
                WHERE v.ativo = 1";
        
        $params = [];
        $types = "";

        // Filtro por texto livre
        if (!empty($pesquisa)) {
            $sql .= " AND v.nome LIKE ?";
            $params[] = "%" . $pesquisa . "%";
            $types .= "s";
        }

        // Filtro por região
        if (!empty($regiao_id)) {
            $sql .= " AND v.regiao_id = ?";
            $params[] = $regiao_id;
            $types .= "i";
        }

        // Filtro por tipo
        if (!empty($tipo_id)) {
            $sql .= " AND v.tipo_id = ?";
            $params[] = $tipo_id;
            $types .= "i";
        }

        // Ordenação e paginação (LIMIT e OFFSET)
        $sql .= " ORDER BY v.nome ASC LIMIT ? OFFSET ?";
        $params[] = $limite;
        $params[] = $offset;
        $types .= "ii";

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Obter o total de vinhos ativos para calcular o número de páginas
    public function getTotalCount($pesquisa = '', $regiao_id = '', $tipo_id = '') {
        $sql = "SELECT COUNT(*) as total FROM vinhos v WHERE v.ativo = 1";
        $params = [];
        $types = "";

        if (!empty($pesquisa)) {
            $sql .= " AND v.nome LIKE ?";
            $params[] = "%" . $pesquisa . "%";
            $types .= "s";
        }

        if (!empty($regiao_id)) {
            $sql .= " AND v.regiao_id = ?";
            $params[] = $regiao_id;
            $types .= "i";
        }

        if (!empty($tipo_id)) {
            $sql .= " AND v.tipo_id = ?";
            $params[] = $tipo_id;
            $types .= "i";
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'] ?? 0;
    }

    // Listar vinhos ativos (usado pela API)
    public function getAll($pesquisa = '', $regiao_id = '', $tipo_id = '') {
        return $this->getPaginated($pesquisa, $regiao_id, $tipo_id, 1000, 0);
    }

    // Listar vinhos que estão na Lixeira (ativo = 0)
    public function getLixeira() {
        $sql = "SELECT v.id, v.nome, r.nome AS regiao, t.tipo 
                FROM vinhos v
                LEFT JOIN regioes r ON v.regiao_id = r.id
                LEFT JOIN tipos_vinho t ON v.tipo_id = t.id
                WHERE v.ativo = 0
                ORDER BY v.nome ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obter vinho por ID
    public function getById($id) {
        $sql = "SELECT * FROM vinhos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Criar novo vinho
    public function create($nome, $regiao_id, $tipo_id) {
        $sql = "INSERT INTO vinhos (nome, regiao_id, tipo_id, ativo) VALUES (?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sii", $nome, $regiao_id, $tipo_id);
        return $stmt->execute();
    }

    // Atualizar vinho
    public function update($id, $nome, $regiao_id, $tipo_id) {
        $sql = "UPDATE vinhos SET nome = ?, regiao_id = ?, tipo_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siii", $nome, $regiao_id, $tipo_id, $id);
        return $stmt->execute();
    }

    // Soft Delete (Mover para a lixeira)
    public function delete($id) {
        $sql = "UPDATE vinhos SET ativo = 0 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Restaurar vinho
    public function restore($id) {
        $sql = "UPDATE vinhos SET ativo = 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Hard Delete
    public function forceDelete($id) {
        $sql = "DELETE FROM vinhos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}