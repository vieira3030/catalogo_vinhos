<?php
// Iniciar a sessão para suporte a mensagens flash e autenticação
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir constante da URL base para links e redirecionamentos
define('BASE_URL', '/catalogo_vinhos/');

// Carregar o ficheiro de autoload das classes
require_once 'app/load.php';

// Instanciar o encaminhador principal (App)
$app = new App();