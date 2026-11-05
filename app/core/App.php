<?php
// Classe responsável pelo encaminhamento de URLs (Routing)
class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Verificar se o controller existe no URL
        if (isset($url[0])) {
            if (file_exists('app/controllers/' . ucfirst($url[0]) . '.php')) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            } else {
                // Carregar vista 404 caso o controller não exista
                $this->render404();
                return;
            }
        }

        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Verificar se o método existe no controller
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                // Carregar vista 404 caso o método não exista
                $this->render404();
                return;
            }
        }

        // Guardar restantes parâmetros
        $this->params = $url ? array_values($url) : [];

        // Executar a ação
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Carregar a vista de Erro 404
    private function render404() {
        require_once 'app/views/erro404.php';
    }

    // Tratar e dividir o URL em segmentos
    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $base = '/catalogo_vinhos/';
        
        if (strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }

        $uri = trim($uri, '/');
        
        if (!empty($uri)) {
            return explode('/', filter_var($uri, FILTER_SANITIZE_URL));
        }

        return [];
    }
}