<?php
class Home extends Controller {

    public function index() {
        $vinhoModel = $this->model('Vinho');
        $regiaoModel = $this->model('Regiao');
        $tipoModel = $this->model('Tipo');

        // Capturar filtros
        $pesquisa = $_GET['q'] ?? '';
        $regiao_id = $_GET['regiao_id'] ?? '';
        $tipo_id = $_GET['tipo_id'] ?? '';

        // Definir limite de 6 vinhos por página (2 linhas de 3 cartões)
        $limite = 6;
        $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;
        
        // Calcular offset para a consulta SQL
        $offset = ($pagina - 1) * $limite;

        // Total de vinhos e total de páginas
        $totalVinhos = $vinhoModel->getTotalCount($pesquisa, $regiao_id, $tipo_id);
        $totalPaginas = ceil($totalVinhos / $limite);
        if ($totalPaginas < 1) $totalPaginas = 1;

        // Obter apenas os vinhos da página atual
        $vinhos = $vinhoModel->getPaginated($pesquisa, $regiao_id, $tipo_id, $limite, $offset);

        // Enviar os dados para a vista
        $this->view('home/index', [
            'vinhos' => $vinhos,
            'regioes' => $regiaoModel->getAll(),
            'tipos' => $tipoModel->getAll(),
            'pesquisa' => $pesquisa,
            'regiao_selecionada' => $regiao_id,
            'tipo_selecionado' => $tipo_id,
            'pagina_atual' => $pagina,
            'total_paginas' => $totalPaginas,
            'total_registos' => $totalVinhos
        ]);
    }
}