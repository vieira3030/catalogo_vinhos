<?php
// Modelo responsável pela gestão das regiões vitivinícolas
class Regiao {
    private $db;

    public function __construct() {
        // Conexão à base de dados MySQLi
        $this->db = (new Db())->conn;
    }

    // Listar apenas as regiões predefinidas nas listas suspensas
    public function getAll() {
        $sql = "SELECT * FROM regioes WHERE personalizada = 0 ORDER BY nome ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Procura uma região pelo nome; se não existir, cria como personalizada (1)
    public function findOrCreate($nome) {
        $nome = trim($nome);
        if (empty($nome)) return null;

        // Verificar se já existe (ignorando maiúsculas/minúsculas)
        $stmt = $this->db->prepare("SELECT id FROM regioes WHERE LOWER(nome) = LOWER(?) LIMIT 1");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res) {
            return (int)$res['id'];
        }

        // Criar nova região marcada como personalizada
        $ins = $this->db->prepare("INSERT INTO regioes (nome, personalizada) VALUES (?, 1)");
        $ins->bind_param("s", $nome);
        $ins->execute();
        return (int)$this->db->insert_id;
    }

    // Alias de compatibilidade
    public function getOrCreate($nome) {
        return $this->findOrCreate($nome);
    }
}