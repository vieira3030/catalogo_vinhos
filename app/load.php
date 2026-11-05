<?php
// Carregamento automático de classes das pastas core e models
spl_autoload_register(function ($className) {
    if (file_exists('app/core/' . $className . '.php')) {
        require_once 'app/core/' . $className . '.php';
    } elseif (file_exists('app/models/' . $className . '.php')) {
        require_once 'app/models/' . $className . '.php';
    }
});