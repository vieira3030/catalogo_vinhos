<?php
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

        // Se preencheu a nova região no campo texto, usa ou cria; caso contrário usa a da lista
        $regiao_id = !empty($_POST['nova_regiao']) 
            ? $regiaoModel->getOrCreate($_POST['nova_regiao']) 
            : (!empty($_POST['regiao_id']) ? $_POST['regiao_id'] : null);

        // Se preencheu o novo tipo no campo texto, usa ou cria; caso contrário usa o da lista
        $tipo_id = !empty($_POST['novo_tipo']) 
            ? $tipoModel->getOrCreate($_POST['novo_tipo']) 
            : (!empty($_POST['tipo_id']) ? $_POST['tipo_id'] : null);

        if (!empty($nome)) {
            $vinhoModel = $this->model('Vinho');
            $vinhoModel->create($nome, $regiao_id, $tipo_id);
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

    // Atualizar vinho
    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nome = trim($_POST['nome']);
            $regiao_id = !empty($_POST['regiao_id']) ? $_POST['regiao_id'] : null;
            $tipo_id = !empty($_POST['tipo_id']) ? $_POST['tipo_id'] : null;

            if (!empty($id) && !empty($nome)) {
                $vinhoModel = $this->model('Vinho');
                $vinhoModel->update($id, $nome, $regiao_id, $tipo_id);
            }
        }
        header('Location: ' . BASE_URL);
        exit;
    }

    // Mover para a Lixeira (Soft Delete)
    public function apagar($id = null) {
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinhoModel->delete($id);
        }
        header('Location: ' . BASE_URL);
        exit;
    }

    // Ver itens na Lixeira
    public function lixeira() {
        $vinhoModel = $this->model('Vinho');
        $vinhos = $vinhoModel->getLixeira();
        $this->view('vinhos/lixeira', ['vinhos' => $vinhos]);
    }

    // Restaurar vinho
    public function restaurar($id = null) {
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinhoModel->restore($id);
        }
        header('Location: ' . BASE_URL . 'vinhos/lixeira');
        exit;
    }

    // Eliminar definitivamente
    public function destruir($id = null) {
        if ($id) {
            $vinhoModel = $this->model('Vinho');
            $vinhoModel->forceDelete($id);
        }
        header('Location: ' . BASE_URL . 'vinhos/lixeira');
        exit;
    }
}