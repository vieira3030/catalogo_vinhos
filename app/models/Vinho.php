<?php
// Modelo responsável pelos dados dos vinhos e favoritos por utilizador
class Vinho {
    private $db;

    public function __construct() {
        $this->db = (new Db())->conn;
    }

    // Listar vinhos (públicos + da conta atual) com favoritos individuais
    public function getPaginated($pesquisa = '', $regiao_id = '', $tipo_id = '', $ordem = 'nome_asc', $apenas_favoritos = 0, $user_id = null, $limite = 6, $offset = 0) {
        $uid = $user_id ? (int)$user_id : 0;

        $sql = "SELECT v.id, v.nome, v.user_id, r.nome AS regiao, t.tipo,
                       IF(f.id IS NOT NULL, 1, 0) AS favorito
                FROM vinhos v
                LEFT JOIN regioes r ON v.regiao_id = r.id
                LEFT JOIN tipos_vinho t ON v.tipo_id = t.id
                LEFT JOIN favoritos f ON f.vinho_id = v.id AND f.user_id = ?
                WHERE v.ativo = 1 AND (v.user_id IS NULL OR v.user_id = ?)";
        
        $params = [$uid, $uid];
        $types = "ii";

        if (!empty($pesquisa)) {
            $sql .= " AND v.nome LIKE ?";
            $params[] = "%" . $pesquisa . "%";
            $types .= "s";
        }

        if (!empty($regiao_id)) {
            $sql .= " AND v.regiao_id = ?";
            $params[] = (int)$regiao_id;
            $types .= "i";
        }

        if (!empty($tipo_id)) {
            $sql .= " AND v.tipo_id = ?";
            $params[] = (int)$tipo_id;
            $types .= "i";
        }

        if ($apenas_favoritos == 1 && $uid > 0) {
            $sql .= " AND f.id IS NOT NULL";
        }

        // Ordenação estritamente alfabética (sem dar prioridade a vinhos criados pelo utilizador)
        switch ($ordem) {
            case 'nome_desc':
                $sql .= " ORDER BY LOWER(TRIM(v.nome)) DESC";
                break;
            case 'regiao_asc':
                $sql .= " ORDER BY r.nome IS NULL ASC, LOWER(TRIM(r.nome)) ASC, LOWER(TRIM(v.nome)) ASC";
                break;
            case 'tipo_asc':
                $sql .= " ORDER BY t.tipo IS NULL ASC, LOWER(TRIM(t.tipo)) ASC, LOWER(TRIM(v.nome)) ASC";
                break;
            case 'nome_asc':
            default:
                $sql .= " ORDER BY LOWER(TRIM(v.nome)) ASC";
                break;
        }
        
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = (int)$limite;
        $params[] = (int)$offset;
        $types .= "ii";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Contar total de vinhos visíveis para a conta atual
    public function getTotalCount($pesquisa = '', $regiao_id = '', $tipo_id = '', $apenas_favoritos = 0, $user_id = null) {
        $uid = $user_id ? (int)$user_id : 0;

        $sql = "SELECT COUNT(*) as total 
                FROM vinhos v 
                LEFT JOIN favoritos f ON f.vinho_id = v.id AND f.user_id = ?
                WHERE v.ativo = 1 AND (v.user_id IS NULL OR v.user_id = ?)";
        $params = [$uid, $uid];
        $types = "ii";

        if (!empty($pesquisa)) {
            $sql .= " AND v.nome LIKE ?";
            $params[] = "%" . $pesquisa . "%";
            $types .= "s";
        }

        if (!empty($regiao_id)) {
            $sql .= " AND v.regiao_id = ?";
            $params[] = (int)$regiao_id;
            $types .= "i";
        }

        if (!empty($tipo_id)) {
            $sql .= " AND v.tipo_id = ?";
            $params[] = (int)$tipo_id;
            $types .= "i";
        }

        if ($apenas_favoritos == 1 && $uid > 0) {
            $sql .= " AND f.id IS NOT NULL";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'] ?? 0;
    }

    // Adicionar ou remover favorito apenas para o utilizador autenticado
    public function toggleFavorito($vinho_id, $user_id) {
        $check = $this->db->prepare("SELECT id FROM favoritos WHERE user_id = ? AND vinho_id = ?");
        $check->bind_param("ii", $user_id, $vinho_id);
        $check->execute();
        $existe = $check->get_result()->fetch_assoc();

        if ($existe) {
            $del = $this->db->prepare("DELETE FROM favoritos WHERE user_id = ? AND vinho_id = ?");
            $del->bind_param("ii", $user_id, $vinho_id);
            $del->execute();
            return false; // Removido
        } else {
            $ins = $this->db->prepare("INSERT INTO favoritos (user_id, vinho_id) VALUES (?, ?)");
            $ins->bind_param("ii", $user_id, $vinho_id);
            $ins->execute();
            return true; // Adicionado
        }
    }

    // Listar vinhos públicos para a API REST
    public function getAll($pesquisa = '', $regiao_id = '', $tipo_id = '') {
        return $this->getPaginated($pesquisa, $regiao_id, $tipo_id, 'nome_asc', 0, null, 1000, 0);
    }

    // Lixeira do utilizador (inclui vinhos base e vinhos criados pela própria conta)
    public function getLixeira($user_id) {
        $sql = "SELECT v.id, v.nome, r.nome AS regiao, t.tipo 
                FROM vinhos v
                LEFT JOIN regioes r ON v.regiao_id = r.id
                LEFT JOIN tipos_vinho t ON v.tipo_id = t.id
                WHERE v.ativo = 0 AND (v.user_id IS NULL OR v.user_id = ?)
                ORDER BY v.nome ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

   // Obter vinho por ID com nome da região e do tipo
 public function getById($id) {
     $sql = "SELECT v.*, r.nome AS regiao_nome, r.personalizada AS regiao_pers,
                    t.tipo AS tipo_nome, t.personalizada AS tipo_pers
             FROM vinhos v
             LEFT JOIN regioes r ON v.regiao_id = r.id
             LEFT JOIN tipos_vinho t ON v.tipo_id = t.id
             WHERE v.id = ?";
     $stmt = $this->db->prepare($sql);
     $stmt->bind_param("i", $id);
     $stmt->execute();
     return $stmt->get_result()->fetch_assoc();
 }

    // Criar vinho associado à conta atual
    public function create($nome, $regiao_id, $tipo_id, $user_id) {
        $sql = "INSERT INTO vinhos (nome, regiao_id, tipo_id, ativo, user_id) VALUES (?, ?, ?, 1, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siii", $nome, $regiao_id, $tipo_id, $user_id);
        return $stmt->execute();
    }

    // Atualizar vinho (base ou da própria conta)
    public function update($id, $nome, $regiao_id, $tipo_id, $user_id) {
        $sql = "UPDATE vinhos SET nome = ?, regiao_id = ?, tipo_id = ? WHERE id = ? AND (user_id IS NULL OR user_id = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siiii", $nome, $regiao_id, $tipo_id, $id, $user_id);
        return $stmt->execute();
    }

    // Mover para a lixeira
    public function delete($id, $user_id) {
        $sql = "UPDATE vinhos SET ativo = 0 WHERE id = ? AND (user_id IS NULL OR user_id = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    // Restaurar da lixeira
    public function restore($id, $user_id) {
        $sql = "UPDATE vinhos SET ativo = 1 WHERE id = ? AND (user_id IS NULL OR user_id = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    // Eliminar permanentemente
    public function forceDelete($id, $user_id) {
        $sql = "DELETE FROM vinhos WHERE id = ? AND (user_id IS NULL OR user_id = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    // Contar estatísticas da conta para a página de perfil
    public function getStatsUtilizador($user_id) {
        $v = $this->db->prepare("SELECT COUNT(*) as total FROM vinhos WHERE user_id = ? AND ativo = 1");
        $v->bind_param("i", $user_id);
        $v->execute();
        $totalVinhos = $v->get_result()->fetch_assoc()['total'] ?? 0;

        $f = $this->db->prepare("SELECT COUNT(*) as total FROM favoritos WHERE user_id = ?");
        $f->bind_param("i", $user_id);
        $f->execute();
        $totalFavs = $f->get_result()->fetch_assoc()['total'] ?? 0;

        return ['vinhos' => $totalVinhos, 'favoritos' => $totalFavs];
    }

    // Eliminar permanentemente todos os vinhos da lixeira do utilizador
    public function esvaziarLixeira($user_id) {
        // Remover primeiro referências na tabela de favoritos
        $sqlFav = "DELETE f FROM favoritos f
                   INNER JOIN vinhos v ON f.vinho_id = v.id
                   WHERE v.ativo = 0 AND (v.user_id = ? OR v.user_id IS NULL)";
        $stmtFav = $this->db->prepare($sqlFav);
        $stmtFav->bind_param("i", $user_id);
        $stmtFav->execute();

        // Eliminar os vinhos inativos (da conta ou base)
        $sql = "DELETE FROM vinhos WHERE ativo = 0 AND (user_id = ? OR user_id IS NULL)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}