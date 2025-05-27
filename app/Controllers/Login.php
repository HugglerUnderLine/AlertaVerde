<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
// OrgaoModel não é usado diretamente no fluxo de login aqui, a menos que você precise carregar dados do órgão na sessão.
// use App\Models\OrgaoModel; 

class Login extends BaseController
{
    public $session;

    public function __construct() {
        $this->session = session();
    }

    /**
     * Exibe a página de login.
     */
    public function index() {
        // Se já está logado, redireciona para o painel apropriado
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
        // Validação inicial da requisição
        if (!$this->request->is('AJAX') || !$this->request->is('POST')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Acesso não permitido.'
            ]);
        }

        // Obtem e valida os dados do POST
        $email = trim($this->request->getPost('email'));
        $senha = $this->request->getPost('senha');
        $tipoContaFormulario = trim($this->request->getPost('tipoConta')); 

        // Validação básica de campos vazios
        if (empty($email) || empty($senha) || empty($tipoContaFormulario)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'E-mail, senha e tipo de conta são obrigatórios.'
            ]);
        }
        
        // Valida se o tipoContaFormulario é esperado
        if (!in_array($tipoContaFormulario, ['cidadao', 'orgao'])) {
             return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tipo de conta inválido.'
            ]);
        }

        // Verifica a consistência com $tipoUsuarioDaUrl se ele for usado e relevante
        if ($tipoUsuarioDaUrl !== null && $tipoUsuarioDaUrl !== $tipoContaFormulario) {
            log_message('warning', "LoginController: Inconsistência no tipo de conta: URL '{$tipoUsuarioDaUrl}' vs Formulário '{$tipoContaFormulario}'");
        }

        // Busca o usuário pelo e-mail
        $usuarioModel = new UsuarioModel();
        $usuarioData = $usuarioModel->findUserByEmail($email); 

        if (!$usuarioData) { 
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuário e/ou senha inválido(s).'
            ]);
        }

        $usuarioData = $usuarioData[0];

        // Verifica a senha passada no formulário
        if (!password_verify($senha, $usuarioData['senha'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuário e/ou senha inválido(s).'
            ]);
        }

        // Verifica se o usuário está ativo
        if (empty($usuarioData['ativo']) || $usuarioData['ativo'] != 1) {
             return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Esta conta de usuário está desativada.'
            ]);
        }

        // Verifica a correspondência do tipo de conta
        $tipoUsuarioBanco = $usuarioData['tipo_usuario']; // 'cidadao', 'orgao_master', 'orgao_representante'
        $loginPermitido = false;

        if ($tipoContaFormulario === 'cidadao' && $tipoUsuarioBanco === 'cidadao') {
            $loginPermitido = true;
        } elseif ($tipoContaFormulario === 'orgao' && in_array($tipoUsuarioBanco, ['orgao_master', 'orgao_representante'])) {
            $loginPermitido = true;
        }

        if (!$loginPermitido) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'O tipo de conta selecionado não é compatível com este usuário.'
            ]);
        }

        // Prepara os dados da sessão
        $nomeCompleto = $usuarioData['nome_completo'] ?? ($usuarioData['nome'] . ' ' . ($usuarioData['sobrenome'] ?? ''));
        $partesNome = explode(' ', trim($nomeCompleto));
        $nomeReduzido = $nomeCompleto; // Padrão
        if (count($partesNome) > 1) {
            $nomeReduzido = $partesNome[0] . ' ' . end($partesNome);
        } elseif (count($partesNome) === 1 && !empty($partesNome[0])) {
            $nomeReduzido = $partesNome[0];
        }
        
        $newdataSessao = [
            'email'         => $usuarioData['email'],
            'uuid'          => $usuarioData['user_uuid'],
            'id_usuario'    => $usuarioData['id_usuario'],
            'id_orgao'      => $usuarioData['id_orgao_fk'] ?? null,
            'nome_completo' => $nomeCompleto,
            'nome_reduzido' => $nomeReduzido,
            'tipo_usuario'  => $tipoUsuarioBanco, // Usar o tipo do banco para a sessão
            'autenticado'   => true,
        ];

        $this->session->set($newdataSessao);
        
        // Possível implementação futura: Adicionar um campo com o último login do usuário.
        // $usuarioModel->update($usuarioData['id_usuario'], ['ultimo_login' => date('Y-m-d H:i:s')]);

        // Retorna sucesso
        return $this->response->setJSON([
            'status' => 'success',
            // URL de redirecionamento construída com base no tipo de conta do formulário
            'redirect_url' => base_url('painel/' . $tipoContaFormulario) 
        ]);
    }

    public function logout() {
        $this->session->destroy();
        return redirect()->to(base_url('login'));
    }
}