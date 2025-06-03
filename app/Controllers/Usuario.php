<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrgaoModel;
use App\Models\OrgaoTipoDenunciaAtuacaoModel;
use App\Models\TipoDenunciaModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Usuario extends BaseController
{
    protected $helpers = ['misc_helper'];

    # Regras de validação de formulário do CodeIgniter
    protected $regrasUsuario = [
        'nome_completo' => [
            'rules' => 'required|min_length[5]|max_length[250]',
            'errors' => [
                'required' => 'O nome é obrigatório.',
                'min_length' => 'O nome informado é muito curto.',
                'max_length' => 'O nome informado é muito longo.',
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email|max_length[255]',
            'errors' => [
                'required' => 'O e-mail é obrigatório.',
                'valid_email' => 'Por favor, insira um e-mail de acesso válido.',
                'max_length' => 'O e-mail informado é muito longo.',
            ]
        ],
        'senha' => [
            'rules' => 'required|min_length[8]|max_length[256]',
            'errors' => [
                'required' => 'A senha é obrigatória.',
                'min_length' => 'A senha informada é muito curta.',
                'max_length' => 'A senha informada é muito longa.',
            ]
        ],
        'confirmarSenha' => [
            'rules' => 'required|matches[senha]',
            'errors' => [
                'required' => 'A confirmação de senha é obrigatória.',
                'matches' => 'As senhas não correspondem.',
            ]
        ],
        'tipo_usuario' => [
            'rules' => 'required|in_list[cidadao,orgao_master,orgao_representante,admin]',
            'errors' => [
                'required' => 'O tipo da conta é obrigatório.',
                'in_list' => 'O tipo da conta é inválido.',
            ],
        ]
    ];

    protected $regrasOrgao = [
        'nome_orgao' => [
            'rules' => 'required|min_length[10]|max_length[150]',
            'errors' => [
                'required' => 'O nome do órgão é obrigatório.',
                'min_length' => 'O nome do órgão informado é muito curto.',
                'max_length' => 'O nome do órgão informado é muito longo.',
            ]
        ],
        'descricao' => [
            'rules' => 'required|min_length[10]|max_length[4000]',
            'errors' => [
                'required' => 'A descrição do órgão é obrigatória.',
                'min_length' => 'A descrição informada é muito curta.',
                'max_length' => 'A descrição informada é muito longa.',
            ]
        ],
        'telefone_contato' => [
            'rules' => 'required|min_length[10]|max_length[20]',
            'errors' => [
                'required' => 'O telefone de contato é obrigatório.',
                'min_length' => 'O telefone informado é muito curto.',
                'max_length' => 'O telefone informado é muito longo.',
            ]
        ],
        'cep' => [
            'rules' => 'required|min_length[8]|max_length[9]',
            'errors' => [
                'required' => 'O CEP é obrigatório.',
                'min_length' => 'O CEP informado é muito curto.',
                'max_length' => 'O CEP informado é muito longo.',
            ]
        ],
        'logradouro' => [
            'rules' => 'required|min_length[5]|max_length[150]',
            'errors' => [
                'required' => 'O logradouro é obrigatório.',
                'min_length' => 'O logradouro informado é muito curto.',
                'max_length' => 'O logradouro informado é muito longo.',
            ]
        ],
        'numero' => [
            'rules' => 'required|min_length[1]|max_length[6]',
            'errors' => [
                'required' => 'O número é obrigatório.',
                'min_length' => 'O número informado é muito curto.',
                'max_length' => 'O número informado é muito longo.',
            ]
        ],
        'bairro' => [
            'rules' => 'required|min_length[3]|max_length[125]',
            'errors' => [
                'required' => 'O bairro é obrigatório.',
                'min_length' => 'O bairro informado é muito curto.',
                'max_length' => 'O bairro informado é muito longo.',
            ]
        ],
        'ponto_referencia' => [
            'rules' => 'max_length[150]',
            'errors' => [
                'max_length' => 'O bairro informado é muito longo.',
            ]
        ],
        'email_institucional' => [
            'rules' => 'required|valid_email|max_length[255]',
            'errors' => [
                'required' => 'O E-mail institucional é obrigatório.',
                'valid_email' => 'Por favor, insira um e-mail institucional válido.',
                'max_length' => 'O e-mail informado é muito longo.',
            ]
        ],
    ];

    # Regras de validação de senha
    protected $passwordRules = [
        'senha_atual' => [
            'rules' => 'required|min_length[8]|max_length[256]',
            'errors' => [
                'required' => 'A senha atual é obrigatória.',
                'max_length' => 'A senha atual é muito longa.',
            ]
        ],
        'nova_senha' => [
            'rules' => 'required|min_length[8]|max_length[256]|differs[senha_atual]',
            'errors' => [
                'required' => 'Por favor, insira sua nova senha.',
                'min_length' => 'Sua nova senha é muito curta.',
                'max_length' => 'Sua nova senha é muito longa.',
                'differs' => 'Sua nova senha não pode ser igual a atual.',
            ]
        ],
        'confirmar_senha' => [
            'rules' => 'required|matches[nova_senha]',
            'errors' => [
                'required' => 'A confirmação da sua nova senha é obrigatória.',
                'matches' => 'A sua nova senha e a confirmação da mesma devem ser idênticas.',
            ]
        ]
    ];

    public function index() {
        if(!$this->request->is('POST')) {
            return view('usuarios');
        }
    }

    public function json_list() {
        if(!$this->request->is('AJAX')) {
            return;
        }

        // log_message('info', json_encode($this->request->getPost(), JSON_PRETTY_PRINT));

        $vars = array();
        # Parâmetros padrão e filtros do Datatables
        $vars = [
            'draw'         => strval($this->request->getPost('draw')),
            'start'        => strval($this->request->getPost('start')),
            'length'       => strval($this->request->getPost('length')),
            'order'        => $this->request->getPost('order'),
            'ativo'        => $this->request->getPost('ativo'),
            'coluna_busca' => $this->request->getPost('coluna_busca'),
            'id_orgao'     => session('tipo_usuario') !== 'admin' ? session('id_orgao') : null,
        ];

        if (!empty($vars['coluna_busca'])) {
            if ($vars['coluna_busca'] === 'nomeUsuario') {
                $vars['nome'] = uniformiza_string($this->request->getPost('valor_busca'));

            } else if ($vars['coluna_busca'] === 'email') {
                $vars['email'] = mb_strtolower(uniformiza_string($this->request->getPost('valor_busca')));
            }
        }

        if ($vars['ativo'] === '1' || $vars['ativo'] === '0') {
            $vars['ativo'] = intval($vars['ativo']);
        } else {
            $vars['ativo'] = null;
        }

        unset($vars['coluna_busca']);

        // log_message('info', json_encode($vars, JSON_PRETTY_PRINT));
        $usuarioModel = new UsuarioModel();

        # Colunas utilizadas no Datatables (usados para sorting na base)
        $cols = ['id_usuario', 'user_uuid', 'nome_completo', 'email', 'tipo_conta', 'ativo', 'criado_em', 'acoes'];

        // log_message('info', json_encode($cols, JSON_PRETTY_PRINT));

        $array4json = array();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $usuarioModel->builder()->countAllResults();

        [$array4json['data'], $array4json['recordsFiltered']] = $usuarioModel->complexGetUsuarios($vars, $cols);

        // log_message('info', json_encode($array4json, JSON_PRETTY_PRINT));

        return json_encode($array4json, JSON_PRETTY_PRINT);
    }

    public function cadastrar_usuario($tipoUsuario = null) {
        $tipoDenuncia = new TipoDenunciaModel();
        $dataTipo['competenciasOrgao'] = $tipoDenuncia->getTiposDenuncia();

        if(!$this->request->is('POST')) {
            return view('cadastro', $dataTipo);
        }

        if($tipoUsuario !== 'orgao' && $tipoUsuario !== 'cidadao') {
            return redirect()->to(base_url('home'));
        }

        $data = $this->request->getPost();

        // log_message('info', json_encode($data, JSON_PRETTY_PRINT));

        $newDataUser = [];

        if($tipoUsuario === 'cidadao') {

            $newDataUser = [
                'nome_completo' => uniformiza_string($data['nome_completo']),
                'email'         => mb_strtolower(uniformiza_string($data['email_cidadao'])),
                'tipo_usuario'  => 'cidadao',
                'id_orgao_fk'   => null,
                'ativo'         => 1,
            ];

        } else {

            $newDataOrgao = [];

            $newDataOrgao = [
                'nome_orgao'          => uniformiza_string($data['nome_orgao']),
                'descricao'           => uniformiza_string($data['descricao']),
                'competencias_orgao'  => $data['competencias_orgao'],
                'telefone_contato'    => uniformiza_string($data['telefone_contato']),
                'email_institucional' => mb_strtolower(uniformiza_string($data['email_institucional'])),
                'cep'                 => uniformiza_string($data['cep']),
                'logradouro'          => uniformiza_string($data['logradouro']),
                'numero'              => uniformiza_string($data['numero']),
                'bairro'              => uniformiza_string($data['bairro']),
                'ponto_referencia'    => uniformiza_string($data['ponto_referencia']),
            ];

            $newDataUser = [
                'nome_completo' => $newDataOrgao['nome_orgao'],
                'email'         => $newDataOrgao['email_institucional'],
                'tipo_usuario'  => 'orgao_master', // Orgao master, orgao_representante, admin
                'id_orgao_fk'   => null,
                'ativo'         => 1,
            ];
            /*
                Obs: o padrão de tipo de usuário para orgãos criados no momento é 'orgao_master'.
                Isso significa que o usuário que acessar com as credenciais do órgao terá
                todas as permissões que referem-se aquele orgao, incluindo adição de novos usuários,
                visualização de denuncias do mesmo, etc.
            */

        }

        $newDataUser['senha'] = $data['senha'];
        $newDataUser['confirmarSenha'] = $data['confirmarSenha'];

        // log_message('info', json_encode($newDataUser, JSON_PRETTY_PRINT));
        // log_message('info', json_encode($newDataOrgao, JSON_PRETTY_PRINT));

        # CodeIgniter Validation
        $errors = [];
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules($this->regrasUsuario);

        $validated = $validation->run($newDataUser);

        if (!$validated) {
            $errors = $validation->getErrors();
        }
    
        if(!empty($errors)) {
            # Erros retornados
            $errorMsg = [];
    
            foreach($errors as $key => $value) {
                $errorMsg[$key] = $value;
            }
    
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => $errorMsg
            ]);
        } 

        # Se for órgão, também precisa validar os campos para armazenamento na tabela orgaos
        if($tipoUsuario === 'orgao') {
            $validation->setRules($this->regrasOrgao);

            $validated = $validation->run($newDataOrgao);

            if (!$validated) {
                $errors = $validation->getErrors();
            }
        
            if(!empty($errors)) {
                # Erros retornados
                $errorMsg = [];
        
                foreach($errors as $key => $value) {
                    $errorMsg[$key] = $value;
                }
        
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => $errorMsg
                ]);
            }
        }

        # Como a validação da senha e sua confirmação já foi realizada, apagamos a variável confirmarSenha
        unset($newDataUser['confirmarSenha']);

        # Verifica se o e-mail recebido do formulário já existe no banco:
        $usuarioModel = new UsuarioModel();
        $validEmail = $usuarioModel->findUserByEmail($newDataUser['email']);

        if(!empty($validEmail[0])) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'O E-mail informado já possui cadastro.'
            ]);
        }

        $newDataUser['user_uuid'] = $usuarioModel->generateUUID();
        $newDataUser['senha'] = password_hash($newDataUser['senha'], PASSWORD_BCRYPT);

        # Inicializa a conexão com o banco de dados para transações
        $db = \Config\Database::connect();

        try {
            if ($tipoUsuario === 'orgao') {
                $orgaoModel = new OrgaoModel();
                $validEmail = $orgaoModel->findOrgaoByEmail($newDataOrgao['email_institucional']);

                if(!empty($validEmail[0])) {
                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'O E-mail informado já possui cadastro.'
                    ]);
                }

                $db->transStart();

                $orgaoID = $orgaoModel->inserirOrgao($newDataOrgao);
                if(!$orgaoID) { 
                    $db->transRollback(); // Cancela a inserção na tabela atual

                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'Um erro inesperado ocorreu ao cadastrar o Órgão. Por favor, tente novamente em alguns instantes.'
                    ]);
                }

                $newDataUser['id_orgao_fk'] = $orgaoID;

                $orgaoTipoDenunciaAtuacao = new OrgaoTipoDenunciaAtuacaoModel();

                foreach($newDataOrgao['competencias_orgao'] as $idTipoDenuncia) {
                    $competencias = [
                        'id_orgao_fk' => $orgaoID,
                        'id_tipo_fk'  => $idTipoDenuncia,
                    ];

                    if (!$orgaoTipoDenunciaAtuacao->insert($competencias)) {
                        log_message('error', 'Falha ao inserir na tabela de ligação orgao_tipo_denuncia_atuacao: ' . json_encode($orgaoTipoDenunciaAtuacao->errors()));
                        throw new \Exception('Erro ao associar tipos de denúncia ao órgão.');
                    }

                }

            }

            if(!$usuarioModel->inserirUsuario($newDataUser)) {
                log_message('error', 'Falha ao inserir usuário: ' . json_encode($usuarioModel->errors()));
                $db->transRollback();

                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Um erro inesperado ocorreu ao cadastrar o usuário. Por favor, tente novamente em alguns instantes.'
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->response->setJSON(['status' => 'error', 'message' => 'Falha ao efetivar o cadastro. Por favor, tente novamente em alguns instantes.']);
            }

            $db->transCommit();
            return $this->response->setJSON(['status' => 'success']);
            
        } catch(\Exception $e) {
            log_message('error', '[CADASTRO USUARIO] Exceção: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            if ($db->transStatus() === true) {
                $db->transRollback();
            }
            return $this->response->setJSON(['status' => 'error', 'message' => 'Ocorreu um erro interno crítico ao processar seu cadastro.']);
        }
    }

    public function upsert($tipoUsuario = null) {
        $tipoDenuncia = new TipoDenunciaModel();
        $dataTipo['competenciasOrgao'] = $tipoDenuncia->getTiposDenuncia();

        if(!$this->request->is('POST')) {
            return view('cadastro', $dataTipo);
        }

        if($tipoUsuario !== 'orgao' && $tipoUsuario !== 'cidadao') {
            return redirect()->to(base_url('home'));
        }

        $data = $this->request->getPost();

        // log_message('info', json_encode($data, JSON_PRETTY_PRINT));

        $newDataUser = [];

        if($tipoUsuario === 'cidadao') {

            $newDataUser = [
                'nome_completo' => uniformiza_string($data['nome_completo']),
                'email'         => mb_strtolower(uniformiza_string($data['email_cidadao'])),
                'tipo_usuario'  => 'cidadao',
                'id_orgao_fk'   => null,
                'ativo'         => 1,
            ];

        } else {

            $newDataOrgao = [];

            $newDataOrgao = [
                'nome_orgao'          => uniformiza_string($data['nome_orgao']),
                'descricao'           => uniformiza_string($data['descricao']),
                'competencias_orgao'  => $data['competencias_orgao'],
                'telefone_contato'    => uniformiza_string($data['telefone_contato']),
                'email_institucional' => mb_strtolower(uniformiza_string($data['email_institucional'])),
                'cep'                 => uniformiza_string($data['cep']),
                'logradouro'          => uniformiza_string($data['logradouro']),
                'numero'              => uniformiza_string($data['numero']),
                'bairro'              => uniformiza_string($data['bairro']),
                'ponto_referencia'    => uniformiza_string($data['ponto_referencia']),
            ];

            $newDataUser = [
                'nome_completo' => $newDataOrgao['nome_orgao'],
                'email'         => $newDataOrgao['email_institucional'],
                'tipo_usuario'  => 'orgao_master', // Orgao master, orgao_representante, admin
                'id_orgao_fk'   => null,
                'ativo'         => 1,
            ];
            /*
                Obs: o padrão de tipo de usuário para orgãos criados no momento é 'orgao_master'.
                Isso significa que o usuário que acessar com as credenciais do órgao terá
                todas as permissões que referem-se aquele orgao, incluindo adição de novos usuários,
                visualização de denuncias do mesmo, etc.
            */

        }

        $newDataUser['senha'] = $data['senha'];
        $newDataUser['confirmarSenha'] = $data['confirmarSenha'];

        // log_message('info', json_encode($newDataUser, JSON_PRETTY_PRINT));
        // log_message('info', json_encode($newDataOrgao, JSON_PRETTY_PRINT));

        # CodeIgniter Validation
        $errors = [];
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules($this->regrasUsuario);

        $validated = $validation->run($newDataUser);

        if (!$validated) {
            $errors = $validation->getErrors();
        }
    
        if(!empty($errors)) {
            # Erros retornados
            $errorMsg = [];
    
            foreach($errors as $key => $value) {
                $errorMsg[$key] = $value;
            }
    
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => $errorMsg
            ]);
        } 

        # Se for órgão, também precisa validar os campos para armazenamento na tabela orgaos
        if($tipoUsuario === 'orgao') {
            $validation->setRules($this->regrasOrgao);

            $validated = $validation->run($newDataOrgao);

            if (!$validated) {
                $errors = $validation->getErrors();
            }
        
            if(!empty($errors)) {
                # Erros retornados
                $errorMsg = [];
        
                foreach($errors as $key => $value) {
                    $errorMsg[$key] = $value;
                }
        
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => $errorMsg
                ]);
            }
        }

        # Como a validação da senha e sua confirmação já foi realizada, apagamos a variável confirmarSenha
        unset($newDataUser['confirmarSenha']);

        # Verifica se o e-mail recebido do formulário já existe no banco:
        $usuarioModel = new UsuarioModel();
        $validEmail = $usuarioModel->findUserByEmail($newDataUser['email']);

        if(!empty($validEmail[0])) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'O E-mail informado já possui cadastro.'
            ]);
        }

        $newDataUser['user_uuid'] = $usuarioModel->generateUUID();
        $newDataUser['senha'] = password_hash($newDataUser['senha'], PASSWORD_BCRYPT);

        // Inicializa a conexão com o banco de dados para transações
        $db = \Config\Database::connect();

        try {
            if ($tipoUsuario === 'orgao') {
                $orgaoModel = new OrgaoModel();
                $validEmail = $orgaoModel->findOrgaoByEmail($newDataOrgao['email_institucional']);

                if(!empty($validEmail[0])) {
                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'O E-mail informado já possui cadastro.'
                    ]);
                }

                $db->transStart();

                $orgaoID = $orgaoModel->inserirOrgao($newDataOrgao);
                if(!$orgaoID) { 
                    $db->transRollback(); // Cancela a inserção na tabela atual

                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'Um erro inesperado ocorreu ao cadastrar o Órgão. Por favor, tente novamente em alguns instantes.'
                    ]);
                }

                $newDataUser['id_orgao_fk'] = $orgaoID;

                $orgaoTipoDenunciaAtuacao = new OrgaoTipoDenunciaAtuacaoModel();

                foreach($newDataOrgao['competencias_orgao'] as $idTipoDenuncia) {
                    $competencias = [
                        'id_orgao_fk' => $orgaoID,
                        'id_tipo_fk'  => $idTipoDenuncia,
                    ];

                    if (!$orgaoTipoDenunciaAtuacao->insert($competencias)) {
                        log_message('error', 'Falha ao inserir na tabela de ligação orgao_tipo_denuncia_atuacao: ' . json_encode($orgaoTipoDenunciaAtuacao->errors()));
                        throw new \Exception('Erro ao associar tipos de denúncia ao órgão.');
                    }

                }

            }

            if(!$usuarioModel->inserirUsuario($newDataUser)) {
                log_message('error', 'Falha ao inserir usuário: ' . json_encode($usuarioModel->errors()));
                $db->transRollback();

                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Um erro inesperado ocorreu ao cadastrar o usuário. Por favor, tente novamente em alguns instantes.'
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->response->setJSON(['status' => 'error', 'message' => 'Falha ao efetivar o cadastro. Por favor, tente novamente em alguns instantes.']);
            }

            $db->transCommit();
            return $this->response->setJSON(['status' => 'success']);
            
        } catch(\Exception $e) {
            log_message('error', '[CADASTRO USUARIO] Exceção: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            if ($db->transStatus() === true) {
                $db->transRollback();
            }
            return $this->response->setJSON(['status' => 'error', 'message' => 'Ocorreu um erro interno crítico ao processar seu cadastro.']);
        }
    }

    public function exibir_perfil() {
        /* 
        * Adicionar a lógica para exibição de perfil,
        * alteração de nome / senha
        */
    }
}
