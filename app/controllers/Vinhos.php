<?php
// Controlador para gestão de vinhos (protegido por sessão)
class Vinhos extends Controller {

    // Exigir sessão iniciada para qualquer modificação
    private function verificarAutenticacao() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = [
                'tipo' => 'erro',
                'texto' => 'Precisas de iniciar sessão para realizar esta ação.'
            ];
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }

    // Exibir formulário de criação de vinho
    public function criar() {
        $this->verificarAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->guardar();
            return;
        }

        $this->view('vinhos/criar', [
            'regioes' => $this->model('Regiao')->getAll(),
            'tipos' => $this->model('Tipo')->getAll()
        ]);
    }

    // Processar e guardar o novo vinho na base de dados
    public function guardar() {
        $this->verificarAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $regiao_id = !empty($_POST['regiao_id']) ? (int)$_POST['regiao_id'] : null;
            $tipo_id = !empty($_POST['tipo_id']) ? (int)$_POST['tipo_id'] : null;

            // Verificar se o utilizador escreveu uma nova região ou tipo
            $nova_regiao = trim($_POST['nova_regiao'] ?? $_POST['regiao'] ?? '');
            $novo_tipo = trim($_POST['novo_tipo'] ?? $_POST['tipo'] ?? '');

            if (!empty($nova_regiao)) {
                $regiao_id = $this->model('Regiao')->findOrCreate($nova_regiao);
            }
            if (!empty($novo_tipo)) {
                $tipo_id = $this->model('Tipo')->findOrCreate($novo_tipo);
            }

            if (!empty($nome)) {
                $this->model('Vinho')->create($nome, $regiao_id, $tipo_id, $_SESSION['user_id']);
                $_SESSION['flash'] = ['tipo' => 'sucesso', 'texto' => 'Vinho adicionado à tua conta!'];
                header('Location: ' . BASE_URL);
                exit;
            }
        }

        header('Location: ' . BASE_URL . 'vinhos/criar');
        exit;
    }

    // Exibir formulário de edição de vinho
    public function editar($id = null) {
        $this->verificarAutenticacao();
        $vinhoModel = $this->model('Vinho');
        $vinho = $vinhoModel->getById($id);

        if (!$vinho || ($vinho['user_id'] !== null && $vinho['user_id'] != $_SESSION['user_id'])) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'texto' => 'Não tens permissão para editar este vinho.'];
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->atualizar($id);
            return;
        }

        $this->view('vinhos/editar', [
            'vinho' => $vinho,
            'regioes' => $this->model('Regiao')->getAll(),
            'tipos' => $this->model('Tipo')->getAll()
        ]);
    }

    // Processar e atualizar os dados do vinho editado
    public function atualizar($id = null) {
        $this->verificarAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nome = trim($_POST['nome'] ?? '');
            $regiao_id = !empty($_POST['regiao_id']) ? (int)$_POST['regiao_id'] : null;
            $tipo_id = !empty($_POST['tipo_id']) ? (int)$_POST['tipo_id'] : null;

            // Verificar se o utilizador escreveu uma nova região ou tipo
            $nova_regiao = trim($_POST['nova_regiao'] ?? $_POST['regiao'] ?? '');
            $novo_tipo = trim($_POST['novo_tipo'] ?? $_POST['tipo'] ?? '');

            if (!empty($nova_regiao)) {
                $regiao_id = $this->model('Regiao')->findOrCreate($nova_regiao);
            }
            if (!empty($novo_tipo)) {
                $tipo_id = $this->model('Tipo')->findOrCreate($novo_tipo);
            }

            if (!empty($nome)) {
                $this->model('Vinho')->update($id, $nome, $regiao_id, $tipo_id, $_SESSION['user_id']);
                $_SESSION['flash'] = ['tipo' => 'sucesso', 'texto' => 'Vinho atualizado com sucesso!'];
            }
        }

        header('Location: ' . BASE_URL);
        exit;
    }

    // Alternar favorito na conta atual
    public function favorito($id = null) {
        $this->verificarAutenticacao();
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinho = $vinhoModel->getById($id);
            if ($vinho) {
                $adicionado = $vinhoModel->toggleFavorito($id, $_SESSION['user_id']);
                $_SESSION['flash'] = [
                    'tipo' => $adicionado ? 'sucesso' : 'aviso',
                    'texto' => $adicionado 
                        ? '⭐ "' . htmlspecialchars($vinho['nome']) . '" adicionado aos teus favoritos!' 
                        : '☆ "' . htmlspecialchars($vinho['nome']) . '" removido dos teus favoritos.'
                ];
            }
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL));
        exit;
    }

    // Mover vinho para a lixeira
    public function apagar($id = null) {
        $this->verificarAutenticacao();
        if ($id) {
            $this->model('Vinho')->delete($id, $_SESSION['user_id']);
            $_SESSION['flash'] = ['tipo' => 'aviso', 'texto' => 'Vinho movido para a lixeira.'];
        }
        header('Location: ' . BASE_URL);
        exit;
    }

    // Listar lixeira da conta
    public function lixeira() {
        $this->verificarAutenticacao();
        $vinhos = $this->model('Vinho')->getLixeira($_SESSION['user_id']);
        $this->view('vinhos/lixeira', ['vinhos' => $vinhos]);
    }

    // Restaurar vinho da lixeira
    public function restaurar($id = null) {
        $this->verificarAutenticacao();
        if ($id) {
            $this->model('Vinho')->restore($id, $_SESSION['user_id']);
            $_SESSION['flash'] = ['tipo' => 'sucesso', 'texto' => 'Vinho restaurado para o catálogo!'];
        }
        header('Location: ' . BASE_URL . 'vinhos/lixeira');
        exit;
    }

    // Eliminar permanentemente
    public function destruir($id = null) {
        $this->verificarAutenticacao();
        if ($id) {
            $this->model('Vinho')->forceDelete($id, $_SESSION['user_id']);
            $_SESSION['flash'] = ['tipo' => 'erro', 'texto' => 'Vinho eliminado permanentemente.'];
        }
        header('Location: ' . BASE_URL . 'vinhos/lixeira');
        exit;
    }

    // Esvaziar todos os vinhos da lixeira
    public function esvaziarLixeira() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        $vinhoModel = $this->model('Vinho');
        $vinhoModel->esvaziarLixeira($_SESSION['user_id']);

        $_SESSION['flash'] = ['tipo' => 'sucesso', 'texto' => 'A lixeira foi esvaziada com sucesso.'];
        header('Location: ' . BASE_URL . 'vinhos/lixeira');
        exit;
    }
}