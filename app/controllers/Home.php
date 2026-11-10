<?php
// Controlador principal da página inicial
class Home extends Controller {

    public function index() {
        $vinhoModel = $this->model('Vinho');
        $regiaoModel = $this->model('Regiao');
        $tipoModel = $this->model('Tipo');

        // Capturar filtros de pesquisa e critério de ordenação
        $pesquisa = $_GET['q'] ?? '';
        $regiao_id = $_GET['regiao_id'] ?? '';
        $tipo_id = $_GET['tipo_id'] ?? '';
        $ordem = $_GET['ordem'] ?? 'nome_asc';

        // Definição da paginação (6 cartões por página)
        $limite = 6;
        $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;
        
        $offset = ($pagina - 1) * $limite;

        // Obter totais para o cálculo do número de páginas
        $totalVinhos = $vinhoModel->getTotalCount($pesquisa, $regiao_id, $tipo_id);
        $totalPaginas = ceil($totalVinhos / $limite);
        if ($totalPaginas < 1) $totalPaginas = 1;

        // Consultar vinhos filtrados e ordenados
        $vinhos = $vinhoModel->getPaginated($pesquisa, $regiao_id, $tipo_id, $ordem, $limite, $offset);

        // Enviar dados para a vista principal
        $this->view('home/index', [
            'vinhos' => $vinhos,
            'regioes' => $regiaoModel->getAll(),
            'tipos' => $tipoModel->getAll(),
            'pesquisa' => $pesquisa,
            'regiao_selecionada' => $regiao_id,
            'tipo_selecionado' => $tipo_id,
            'ordem_selecionada' => $ordem,
            'pagina_atual' => $pagina,
            'total_paginas' => $totalPaginas,
            'total_registos' => $totalVinhos
        ]);
    }
}