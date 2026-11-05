<?php
// Classe de ligação à Base de Dados usando o driver MySQLi
class Db {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "catalogo_vinhos";
    public $conn;

    public function __construct() {
        // Criar a conexão MySQLi
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        // Verificar erros de conexão
        if ($this->conn->connect_error) {
            die("Erro na conexão à Base de Dados: " . $this->conn->connect_error);
        }

        // Definir conjunto de carateres para UTF-8
        $this->conn->set_charset("utf8mb4");
    }
}