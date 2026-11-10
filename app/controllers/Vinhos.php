<?php
// Controlador de Gestão de Vinhos (CRUD + Lixeira + Mensagens Flash)
class Vinhos extends Controller {

    // Exibir formulário de criação
    public function criar() {
        $regiaoModel = $this->model('Regiao');
        $tipoModel = $this->model('Tipo');

        $this->view('vinhos/criar', [
            'regioes' => $regiaoModel->getAll(),
            'tipos' => $tipoModel->getAll()
        ]);
    }

    // Método para guardar um novo vinho
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome']);
            
            $regiaoModel = $this->model('Regiao');
            $tipoModel = $this->model('Tipo');

            // Obter ID existente ou criar nova região/tipo se preenchido
            $regiao_id = !empty($_POST['nova_regiao']) 
                ? $regiaoModel->getOrCreate($_POST['nova_regiao']) 
                : (!empty($_POST['regiao_id']) ? $_POST['regiao_id'] : null);

            $tipo_id = !empty($_POST['novo_tipo']) 
                ? $tipoModel->getOrCreate($_POST['novo_tipo']) 
                : (!empty($_POST['tipo_id']) ? $_POST['tipo_id'] : null);

            if (!empty($nome)) {
                $vinhoModel = $this->model('Vinho');
                $vinhoModel->create($nome, $regiao_id, $tipo_id);

                // Definir mensagem flash de sucesso
                $_SESSION['flash'] = [
                    'tipo' => 'sucesso',
                    'texto' => '🍷 Vinho "' . htmlspecialchars($nome) . '" adicionado com sucesso!'
                ];
            } else {
                // Definir mensagem flash de erro caso falte o nome
                $_SESSION['flash'] = [
                    'tipo' => 'erro',
                    'texto' => '⚠️ O nome do vinho é obrigatório.'
                ];
            }
        }
        header('Location: ' . BASE_URL);
        exit;
    }

    // Exibir formulário de edição
    public function editar($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $vinhoModel = $this->model('Vinho');
        $vinho = $vinhoModel->getById($id);

        if (!$vinho) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $regiaoModel = $this->model('Regiao');
        $tipoModel = $this->model('Tipo');

        $this->view('vinhos/editar', [
            'vinho' => $vinho,
            'regioes' => $regiaoModel->getAll(),
            'tipos' => $tipoModel->getAll()
        ]);
    }

    // Atualizar dados de um vinho
    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nome = trim($_POST['nome']);
            $regiao_id = !empty($_POST['regiao_id']) ? $_POST['regiao_id'] : null;
            $tipo_id = !empty($_POST['tipo_id']) ? $_POST['tipo_id'] : null;

            if (!empty($id) && !empty($nome)) {
                $vinhoModel = $this->model('Vinho');
                $vinhoModel->update($id, $nome, $regiao_id, $tipo_id);

                // Definir mensagem flash de sucesso na alteração
                $_SESSION['flash'] = [
                    'tipo' => 'sucesso',
                    'texto' => '✏️ Vinho "' . htmlspecialchars($nome) . '" atualizado com sucesso!'
                ];
            }
        }
        header('Location: ' . BASE_URL);
        exit;
    }

    // Mover vinho para a Lixeira (Soft Delete)
    public function apagar($id = null) {
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinhoModel->delete($id);

            // Definir mensagem flash de aviso ao mover para lixeira
            $_SESSION['flash'] = [
                'tipo' => 'aviso',
                'texto' => '🗑️ Vinho movido para a lixeira.'
            ];
        }
        header('Location: ' . BASE_URL);
        exit;
    }

    // Exibir registos na Lixeira
    public function lixeira() {
        $vinhoModel = $this->model('Vinho');
        $vinhos = $vinhoModel->getLixeira();
        $this->view('vinhos/lixeira', ['vinhos' => $vinhos]);
    }

    // Restaurar vinho da lixeira
    public function restaurar($id = null) {
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinhoModel->restore($id);

            // Definir mensagem flash de sucesso no restauro
            $_SESSION['flash'] = [
                'tipo' => 'sucesso',
                'texto' => '♻️ Vinho restaurado com sucesso!'
            ];
        }
        header('Location: ' . BASE_URL . 'vinhos/lixeira');
        exit;
    }

    // Eliminar definitivamente o vinho da base de dados
    public function destruir($id = null) {
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinhoModel->forceDelete($id);

            // Definir mensagem flash de remoção permanente
            $_SESSION['flash'] = [
                'tipo' => 'erro',
                'texto' => '❌ Vinho eliminado definitivamente.'
            ];
        }
        header('Location: ' . BASE_URL . 'vinhos/lixeira');
        exit;
    }

    // Alternar o estado de favorito de um vinho com mensagem personalizada
    public function favorito($id = null) {
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinho = $vinhoModel->getById($id);

            if ($vinho) {
                $vinhoModel->toggleFavorito($id);
                $eraFavorito = !empty($vinho['favorito']);

                if (!$eraFavorito) {
                    // Mensagem ao adicionar
                    $_SESSION['flash'] = [
                        'tipo' => 'sucesso',
                        'texto' => '⭐ Vinho "' . htmlspecialchars($vinho['nome']) . '" adicionado aos favoritos!'
                    ];
                } else {
                    // Mensagem ao remover
                    $_SESSION['flash'] = [
                        'tipo' => 'aviso',
                        'texto' => '☆ Vinho "' . htmlspecialchars($vinho['nome']) . '" removido dos favoritos.'
                    ];
                }
            }
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL));
        exit;
    }
}