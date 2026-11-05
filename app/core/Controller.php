<?php
// Super-classe herdada por todos os Controllers da aplicação
class Controller {

    // Método para carregar um Model
    public function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    // Método para carregar uma View e passar dados
    public function view($view, $data = []) {
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            die("A vista '{$view}' não foi encontrada.");
        }
    }
}