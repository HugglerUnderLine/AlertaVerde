<?php

namespace App\Controllers;

use App\Models\LogAuditoriaModel;
use App\Models\OrgaoModel;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    public $session;

    public function __construct() {
        $this->session = session();
    }

    public function index() {
        # Se já está logado, redireciona para o painel apropriado
        if ($this->session->get('autenticado')) {
            $tipoUsuarioSessao = $this->session->get('tipo_usuario');
            $destino = 'painel/';

            if ($tipoUsuarioSessao === 'cidadao') {
                $destino .= 'cidadao';
            } elseif ($tipoUsuarioSessao === 'admin') {
                $destino .= 'admin';
            } elseif (in_array($tipoUsuarioSessao, ['orgao_master', 'orgao_representante'])) {
                $destino .= 'orgao';
            } else {
                $destino = 'home'; // Fallback para um tipo desconhecido
            }
            return redirect()->to(base_url($destino));
        }

        return view('login');
    }

    public function autenticar($tipoUsuarioDaUrl = null) {
        # Validação inicial da requisição
        if (!$this->request->is('AJAX') || !$this->request->is('POST')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Acesso não permitido.'
            ]);
        }

        log_message('info', password_hash('adminroot', PASSWORD_BCRYPT));

        # Obtem e valida os dados do POST
        $email = mb_strtolower(trim($this->request->getPost('email')));
        $senha = $this->request->getPost('senha');
        $tipoContaFormulario = trim($this->request->getPost('tipoConta')); 

        # Validação básica de campos vazios
        if (empty($email) || empty($senha) || empty($tipoContaFormulario)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'E-mail, senha e tipo de conta são obrigatórios.'
            ]);
        }

        $logAuditoriaModel = new LogAuditoriaModel();
        $log = [
            'user_email' => $email,
            'user_action' => 'login',
            'user_ip' => $this->request->getIPAddress(),
        ];
        
        # Valida se o tipoContaFormulario é esperado
        if (!in_array($tipoContaFormulario, ['cidadao', 'orgao'])) {
            $log['detalhes'] = json_encode(['status' => 'error', 'motivo' => 'Tipo de conta inválido.']);
            $logAuditoriaModel->insert($log);

             return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tipo de conta inválido.'
            ]);
        }

        # Verifica a consistência com $tipoUsuarioDaUrl se ele for usado e relevante
        if ($tipoUsuarioDaUrl !== null && $tipoUsuarioDaUrl !== $tipoContaFormulario) {
            log_message('warning', "LoginController: Inconsistência no tipo de conta: URL '{$tipoUsuarioDaUrl}' vs Formulário '{$tipoContaFormulario}'");
        }

        # Busca o usuário pelo e-mail
        $usuarioModel = new UsuarioModel();
        $usuarioData = $usuarioModel->findUserByEmail($email); 

        if (!$usuarioData) { 
        $log['detalhes'] = json_encode(['status' => 'error', 'motivo' => 'Usuário e/ou senha inválidos.']);
        $logAuditoriaModel->insert($log);

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuário e/ou senha inválido(s).'
            ]);
        }

        $usuarioData = $usuarioData[0];

        # Verifica a senha passada no formulário
        if (!password_verify($senha, $usuarioData['senha'])) {
            $log['detalhes'] = json_encode(['status' => 'error', 'motivo' => 'Usuário e/ou senha inválidos.']);
            $logAuditoriaModel->insert($log);

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuário e/ou senha inválido(s).'
            ]);
        }

        # Verifica se o usuário está ativo
        if (empty($usuarioData['ativo']) || $usuarioData['ativo'] != 1) {
            $log['detalhes'] = json_encode(['status' => 'error', 'motivo' => 'A conta desse usuário foi desativada.']);
            $logAuditoriaModel->insert($log);

             return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Esta conta de usuário está desativada.'
            ]);
        }

        # Verifica a correspondência do tipo de conta
        $tipoUsuarioBanco = $usuarioData['tipo_usuario']; // 'cidadao', 'orgao_master', 'orgao_representante'
        $loginPermitido = false;

        if ($tipoContaFormulario === 'cidadao' && $tipoUsuarioBanco === 'cidadao') {
            $loginPermitido = true;
        } elseif ($tipoContaFormulario === 'orgao' && in_array($tipoUsuarioBanco, ['orgao_master', 'orgao_representante', 'admin'])) {
            $loginPermitido = true;

            $orgaoModel = new OrgaoModel();
            $idOrgao = $usuarioData['id_orgao_fk'];

            $orgaoInfo = $orgaoModel->findOrgaoByID($idOrgao);

            $usuarioData['nome_orgao'] = $orgaoInfo['nome_orgao'];
        }

        if (!$loginPermitido) {
            $log['detalhes'] = json_encode(['status' => 'error', 'motivo' => 'Tipo de conta incompatível.']);
            $logAuditoriaModel->insert($log);

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'O tipo de conta selecionado não é compatível com este usuário.'
            ]);
        }

        # Prepara os dados da sessão
        $nomeCompleto = $usuarioData['nome_completo'];
        $partesNome = explode(' ', trim($nomeCompleto));
        $nomeReduzido = $nomeCompleto; // Padrão

        if (!isset($usuarioData['nome_orgao'])) {
            if (count($partesNome) > 1) {
                $nomeReduzido = $partesNome[0] . ' ' . end($partesNome);
            } elseif (count($partesNome) === 1 && !empty($partesNome[0])) {
                $nomeReduzido = $partesNome[0];
            }
        } else {
            $nomeReduzido = $nomeCompleto;
        }

        $newdataSessao = [
            'email'         => $usuarioData['email'],
            'uuid'          => $usuarioData['user_uuid'],
            'id_usuario'    => $usuarioData['id_usuario'],
            'id_orgao'      => $usuarioData['id_orgao_fk'] ?? null,
            'nome_orgao'    => $tipoUsuarioBanco != 'cidadao' && $nomeCompleto != $usuarioData['nome_orgao'] ? $usuarioData['nome_orgao'] : null,
            'nome_completo' => $nomeCompleto,
            'nome_reduzido' => $nomeReduzido,
            'tipo_usuario'  => $tipoUsuarioBanco, // Usa o tipo do banco para a sessão
            'autenticado'   => true,
        ];

        $this->session->set($newdataSessao);

        $log['user_uuid'] = $usuarioData['user_uuid'];
        $log['user_email'] = $usuarioData['email'];
        $log['user_nome_completo'] = $nomeCompleto;
        $log['id_orgao'] = $usuarioData['id_orgao_fk'];
        $log['tipo_usuario'] = $usuarioData['tipo_usuario'];
        $log['detalhes'] = json_encode(['status' => 'sucesso']);
        $logAuditoriaModel->insert($log);

        # Retorna sucesso
        return $this->response->setJSON([
            'status' => 'success',
            # URL de redirecionamento construída com base no tipo de conta do formulário
            'redirect_url' => base_url('painel/' . $tipoContaFormulario) 
        ]);
    }

    public function logout() {
        $logAuditoriaModel = new LogAuditoriaModel();
        $log = [
            'user_action'        => 'logout',
            'user_email'         => session('email'),
            'user_ip'            => $this->request->getIPAddress(),
            'user_uuid'          => session('uuid'),
            'user_nome_completo' => session('nome_completo'),
            'id_orgao'           => session('id_orgao'),
            'tipo_usuario'       => session('tipo_usuario'),
        ];
        $log['detalhes'] = json_encode(['status' => 'sucesso']);
        $logAuditoriaModel->insert($log);

        $this->session->destroy();
        return redirect()->to(base_url('login'));
    }
}