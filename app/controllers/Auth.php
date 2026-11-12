<?php
// Controlador responsável pelo login, registo, perfil e logout
class Auth extends Controller {

    // Iniciar sessão
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = $this->model('Utilizador');
            $user = $userModel->findByUsername($username);

            // Verificar utilizador e password encriptada
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                $_SESSION['flash'] = [
                    'tipo' => 'sucesso',
                    'texto' => 'Sessão iniciada. Bem-vindo, ' . htmlspecialchars($user['username']) . '!'
                ];

                header('Location: ' . BASE_URL);
                exit;
            } else {
                $_SESSION['flash'] = [
                    'tipo' => 'erro',
                    'texto' => 'Nome de utilizador ou palavra-passe incorretos.'
                ];
            }
        }

        $this->view('auth/login');
    }

    // Criar nova conta de utilizador
    public function registar() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmar = $_POST['confirmar_password'] ?? '';

            $userModel = $this->model('Utilizador');

            // Validações básicas
            if (empty($username) || empty($password)) {
                $_SESSION['flash'] = ['tipo' => 'erro', 'texto' => 'Preenche todos os campos.'];
            } elseif ($password !== $confirmar) {
                $_SESSION['flash'] = ['tipo' => 'erro', 'texto' => 'As palavras-passe não coincidem.'];
            } elseif ($userModel->findByUsername($username)) {
                $_SESSION['flash'] = ['tipo' => 'erro', 'texto' => 'Esse nome de utilizador já existe.'];
            } else {
                // Criar utilizador e iniciar sessão automaticamente
                if ($userModel->create($username, $password)) {
                    $novoUser = $userModel->findByUsername($username);
                    $_SESSION['user_id'] = $novoUser['id'];
                    $_SESSION['username'] = $novoUser['username'];

                    $_SESSION['flash'] = [
                        'tipo' => 'sucesso',
                        'texto' => 'Conta criada com sucesso! Bem-vindo, ' . htmlspecialchars($username) . '.'
                    ];
                    header('Location: ' . BASE_URL);
                    exit;
                }
            }
        }

        $this->view('auth/registar');
    }

    // Exibir página de perfil e estatísticas da conta
    public function perfil() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        // Obter contagem de vinhos e favoritos do utilizador
        $stats = $this->model('Vinho')->getStatsUtilizador($_SESSION['user_id']);

        $this->view('auth/perfil', [
            'username' => $_SESSION['username'],
            'stats' => $stats
        ]);
    }

    // Terminar sessão
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);

        $_SESSION['flash'] = [
            'tipo' => 'aviso',
            'texto' => 'Sessão terminada.'
        ];

        header('Location: ' . BASE_URL);
        exit;
    }
}