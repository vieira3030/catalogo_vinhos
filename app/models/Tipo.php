<?php
// Modelo responsável pela gestão dos tipos de vinho
class Tipo {
    private $db;

    public function __construct() {
        // Conexão à base de dados MySQLi
        $this->db = (new Db())->conn;
    }

    // Listar apenas os tipos predefinidos nas listas suspensas
    public function getAll() {
        $sql = "SELECT * FROM tipos_vinho WHERE personalizada = 0 ORDER BY tipo ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Procura um tipo pelo nome; se não existir, cria como personalizado (1)
    public function findOrCreate($tipo) {
        $tipo = trim($tipo);
        if (empty($tipo)) return null;

        // Verificar se já existe (ignorando maiúsculas/minúsculas)
        $stmt = $this->db->prepare("SELECT id FROM tipos_vinho WHERE LOWER(tipo) = LOWER(?) LIMIT 1");
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res) {
            return (int)$res['id'];
        }

        // Criar novo tipo marcado como personalizado
        $ins = $this->db->prepare("INSERT INTO tipos_vinho (tipo, personalizada) VALUES (?, 1)");
        $ins->bind_param("s", $tipo);
        $ins->execute();
        return (int)$this->db->insert_id;
    }

    // Alias de compatibilidade
    public function getOrCreate($tipo) {
        return $this->findOrCreate($tipo);
    }
}