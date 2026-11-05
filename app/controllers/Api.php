<?php
// Controlador responsável por fornecer dados da base de dados em formato JSON
class Api extends Controller {

    // Endpoint para obter a lista de vinhos ou um vinho específico (/api/vinhos ou /api/vinhos/1)
    public function vinhos($id = null) {
        // Definir o cabeçalho HTTP para resposta em formato JSON com UTF-8
        header('Content-Type: application/json; charset=utf-8');

        $vinhoModel = $this->model('Vinho');

        // Se for passado um ID no URL, devolve apenas o detalhe desse vinho
        if ($id) {
            $vinho = $vinhoModel->getById($id);
            if ($vinho) {
                echo json_encode(['status' => 'success', 'data' => $vinho], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Vinho não encontrado'], JSON_UNESCAPED_UNICODE);
            }
        } else {
            // Caso contrário, devolve a lista completa de vinhos ativos
            $vinhos = $vinhoModel->getAll();
            echo json_encode(['status' => 'success', 'count' => count($vinhos), 'data' => $vinhos], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    // Endpoint para obter a lista de regiões (/api/regioes)
    public function regioes() {
        header('Content-Type: application/json; charset=utf-8');
        $regiaoModel = $this->model('Regiao');
        echo json_encode(['status' => 'success', 'data' => $regiaoModel->getAll()], JSON_UNESCAPED_UNICODE);
        exit;
    }
}