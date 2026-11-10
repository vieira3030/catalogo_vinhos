<?php
// Controlador principal da página inicial
class Home extends Controller {

    public function index() {
        $vinhoModel = $this->model('Vinho');
        $regiaoModel = $this->model('Regiao');
        $tipoModel = $this->model('Tipo');

        // Capturar filtros de pesquisa, ordenação e favoritos da query string
        $pesquisa = $_GET['q'] ?? '';
        $regiao_id = $_GET['regiao_id'] ?? '';
        $tipo_id = $_GET['tipo_id'] ?? '';
        $ordem = $_GET['ordem'] ?? 'nome_asc';
        $favoritos = isset($_GET['favoritos']) && $_GET['favoritos'] == '1' ? 1 : 0;

        // Configuração da paginação (6 cartões por página)
        $limite = 6;
        $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;
        
        $offset = ($pagina - 1) * $limite;

        // Obter contagem de registos filtrados
        $totalVinhos = $vinhoModel->getTotalCount($pesquisa, $regiao_id, $tipo_id, $favoritos);
        $totalPaginas = ceil($totalVinhos / $limite);
        if ($totalPaginas < 1) $totalPaginas = 1;

        // Consultar vinhos garantindo a ordem exata dos 7 parâmetros
        $vinhos = $vinhoModel->getPaginated($pesquisa, $regiao_id, $tipo_id, $ordem, $favoritos, $limite, $offset);

        // Enviar os dados para a vista principal
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
            'total_registos' => $totalVinhos
        ]);
    }
}