<?php
// Iniciar a sessão para a aplicação
session_start();

// Definir constante da URL base para links e redirecionamentos
define('BASE_URL', '/catalogo_vinhos/');

// Carregar o ficheiro de autoload das classes
require_once 'app/load.php';

// Instanciar o encaminhador principal (App)
$app = new App();