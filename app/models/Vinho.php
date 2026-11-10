<?php
// Modelo responsável pelos dados dos vinhos na base de dados
class Vinho {
    private $db;

    public function __construct() {
        // Inicializar conexão MySQLi
        $this->db = (new Db())->conn;
    }

    // Listar vinhos ativos com paginação, filtros, ordenação e favoritos
    public function getPaginated($pesquisa = '', $regiao_id = '', $tipo_id = '', $ordem = 'nome_asc', $apenas_favoritos = 0, $limite = 6, $offset = 0) {
        $sql = "SELECT v.id, v.nome, v.favorito, r.nome AS regiao, t.tipo 
                FROM vinhos v
                LEFT JOIN regioes r ON v.regiao_id = r.id
                LEFT JOIN tipos_vinho t ON v.tipo_id = t.id
                WHERE v.ativo = 1";
        
        $params = [];
        $types = "";

        // Aplicar filtro por pesquisa de nome
        if (!empty($pesquisa)) {
            $sql .= " AND v.nome LIKE ?";
            $params[] = "%" . $pesquisa . "%";
            $types .= "s";
        }

        // Aplicar filtro por região
        if (!empty($regiao_id)) {
            $sql .= " AND v.regiao_id = ?";
            $params[] = $regiao_id;
            $types .= "i";
        }

        // Aplicar filtro por tipo de vinho
        if (!empty($tipo_id)) {
            $sql .= " AND v.tipo_id = ?";
            $params[] = $tipo_id;
            $types .= "i";
        }

        // Aplicar filtro por favoritos
        if ($apenas_favoritos == 1) {
            $sql .= " AND v.favorito = 1";
        }

        // Aplicar a ordenação pretendida
        switch ($ordem) {
            case 'nome_desc':
                $sql .= " ORDER BY v.nome DESC";
                break;
            case 'regiao_asc':
                $sql .= " ORDER BY r.nome ASC, v.nome ASC";
                break;
            case 'tipo_asc':
                $sql .= " ORDER BY t.tipo ASC, v.nome ASC";
                break;
            case 'nome_asc':
            default:
                $sql .= " ORDER BY v.nome ASC";
                break;
        }

        // Adicionar limites de paginação
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = (int)$limite;
        $params[] = (int)$offset;
        $types .= "ii";

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Contagem total de registos filtrados
    public function getTotalCount($pesquisa = '', $regiao_id = '', $tipo_id = '', $apenas_favoritos = 0) {
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

        if ($apenas_favoritos == 1) {
            $sql .= " AND v.favorito = 1";
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'] ?? 0;
    }

    // Alternar o estado de favorito de um vinho
    public function toggleFavorito($id) {
        $sql = "UPDATE vinhos SET favorito = NOT favorito WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Listar todos os vinhos ativos (usado pela API REST)
    public function getAll($pesquisa = '', $regiao_id = '', $tipo_id = '') {
        return $this->getPaginated($pesquisa, $regiao_id, $tipo_id, 'nome_asc', 0, 1000, 0);
    }

    // Obter vinhos desativados guardados na lixeira
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

    // Consultar vinho por ID
    public function getById($id) {
        $sql = "SELECT * FROM vinhos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Criar vinho
    public function create($nome, $regiao_id, $tipo_id) {
        $sql = "INSERT INTO vinhos (nome, regiao_id, tipo_id, ativo, favorito) VALUES (?, ?, ?, 1, 0)";
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

    // Restaurar vinho da lixeira
    public function restore($id) {
        $sql = "UPDATE vinhos SET ativo = 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Eliminar permanentemente
    public function forceDelete($id) {
        $sql = "DELETE FROM vinhos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}