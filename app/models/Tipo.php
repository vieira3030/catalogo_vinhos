<?php
class Tipo {
    private $db;

    public function __construct() {
        // Conexão à base de dados MySQLi
        $this->db = (new Db())->conn;
    }

    public function getAll() {
        $sql = "SELECT * FROM tipos_vinho ORDER BY tipo ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Procura um tipo pelo nome; se não existir, cria um novo e devolve o ID
    public function getOrCreate($tipo) {
        $tipo = trim($tipo);
        if (empty($tipo)) return null;

        // Verificar se já existe
        $stmt = $this->db->prepare("SELECT id FROM tipos_vinho WHERE LOWER(tipo) = LOWER(?)");
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res) {
            return $res['id'];
        }

        // Se não existir, insere o novo tipo
        $stmtInsert = $this->db->prepare("INSERT INTO tipos_vinho (tipo) VALUES (?)");
        $stmtInsert->bind_param("s", $tipo);
        $stmtInsert->execute();
        return $stmtInsert->insert_id;
    }
}