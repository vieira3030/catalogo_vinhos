<?php
class Regiao {
    private $db;

    public function __construct() {
        // Conexão à base de dados MySQLi
        $this->db = (new Db())->conn;
    }

    public function getAll() {
        $sql = "SELECT * FROM regioes ORDER BY nome ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Procura uma região pelo nome; se não existir, cria uma nova e devolve o ID
    public function getOrCreate($nome) {
        $nome = trim($nome);
        if (empty($nome)) return null;

        // Verificar se já existe
        $stmt = $this->db->prepare("SELECT id FROM regioes WHERE LOWER(nome) = LOWER(?)");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res) {
            return $res['id'];
        }

        // Se não existir, insere a nova região
        $stmtInsert = $this->db->prepare("INSERT INTO regioes (nome) VALUES (?)");
        $stmtInsert->bind_param("s", $nome);
        $stmtInsert->execute();
        return $stmtInsert->insert_id;
    }
}