<?php
// Controlador responsável pelos endpoints da API REST em formato JSON
class Api extends Controller {

    // Retorna a lista de vinhos ou um vinho específico por ID em JSON
    public function vinhos($id = null) {
        header('Content-Type: application/json; charset=utf-8');
        $vinhoModel = $this->model('Vinho');

        if ($id) {
            $vinho = $vinhoModel->getById($id);
            if ($vinho) {
                echo json_encode($vinho, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['erro' => 'Vinho não encontrado'], JSON_UNESCAPED_UNICODE);
            }
        } else {
            $vinhos = $vinhoModel->getAll();
            echo json_encode($vinhos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        exit;
    }

    // Retorna a lista de todas as regiões vitivinícolas em JSON
    public function regioes() {
        header('Content-Type: application/json; charset=utf-8');
        $regiaoModel = $this->model('Regiao');
        $regioes = $regiaoModel->getAll();
        echo json_encode($regioes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // Retorna a lista de todos os tipos de vinho em JSON
    public function tipos() {
        header('Content-Type: application/json; charset=utf-8');
        $tipoModel = $this->model('Tipo');
        $tipos = $tipoModel->getAll();
        echo json_encode($tipos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}