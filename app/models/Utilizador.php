<?php
// Modelo responsável pela gestão de utilizadores
class Utilizador {
    private $db;

    public function __construct() {
        // Ligação à base de dados via MySQLi
        $this->db = (new Db())->conn;
    }

    // Procurar utilizador pelo nome de utilizador
    public function findByUsername($username) {
        $sql = "SELECT * FROM utilizadores WHERE username = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Registar novo utilizador com password encriptada
    public function create($username, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilizadores (username, password) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $hash);
        return $stmt->execute();
    }
}