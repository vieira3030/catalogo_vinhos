<?php
// Controlador da página principal
class Home extends Controller {

    public function index() {
        $vinhoModel = $this->model('Vinho');
        $regiaoModel = $this->model('Regiao');
        $tipoModel = $this->model('Tipo');

        $user_id = $_SESSION['user_id'] ?? null;

        // Redirecionar para login se tentar aceder aos favoritos sem sessão
        if (isset($_GET['favoritos']) && $_GET['favoritos'] == '1' && !$user_id) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'texto' => 'Inicia sessão para veres os teus favoritos.'];
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        // Obter parâmetros de pesquisa, filtros e ordenação
        $pesquisa = $_GET['q'] ?? '';
        $regiao_id = $_GET['regiao_id'] ?? '';
        $tipo_id = $_GET['tipo_id'] ?? '';
        $ordem = $_GET['ordem'] ?? 'nome_asc';
        $favoritos = ($user_id && isset($_GET['favoritos']) && $_GET['favoritos'] == '1') ? 1 : 0;

        // Configuração da paginação (6 vinhos por página)
        $limite = 6;
        $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;
        $offset = ($pagina - 1) * $limite;

        // Contar registos e obter lista paginada
        $totalVinhos = $vinhoModel->getTotalCount($pesquisa, $regiao_id, $tipo_id, $favoritos, $user_id);
        $totalPaginas = max(1, ceil($totalVinhos / $limite));
        $vinhos = $vinhoModel->getPaginated($pesquisa, $regiao_id, $tipo_id, $ordem, $favoritos, $user_id, $limite, $offset);

        // Enviar dados para a vista principal
        $this->view('home/index', [
            'vinhos' => $vinhos,
            'regioes' => $regiaoModel->getAll(),
            'tipos' => $tipoModel->getAll(),
            'pesquisa' => $pesquisa,
            'regiao_selecionada' => $regiao_id,
            'tipo_selecionado' => $tipo_id,
            'ordem_selecionada' => $ordem,
            'favoritos_selecionado' => $favoritos,
            'pagina_atual' => $pagina,
            'total_paginas' => $totalPaginas,
            'total_vinhos' => $totalVinhos
        ]);
    }
}