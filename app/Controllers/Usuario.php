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

    protected $regrasUsuarioOrgao = [
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
        'tipo_usuario' => [
            'rules' => 'required|in_list[orgao_master,orgao_representante]',
            'errors' => [
                'required' => 'A Permissão do usuário deve ser selecionada.',
                'in_list' => 'A Permissão do usuário é inválida.',
            ],
        ],
        'ativo' => [
            'rules' => 'required|in_list[0,1]',
            'errors' => [
                'required' => 'O Status da conta deve ser selecionado.',
                'in_list' => 'O Status da conta é inválido.',
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
    protected $regrasAtualizacaoUsuario = [
        'nome_completo' => [
            'rules' => 'required|min_length[8]|max_length[256]',
            'errors' => [
                'required' => 'A senha atual é obrigatória.',
                'max_length' => 'A senha atual é muito longa.',
            ]
        ],
        'email' => [
            'rules' => 'required|min_length[8]|max_length[256]',
            'errors' => [
                'required' => 'A senha atual é obrigatória.',
                'max_length' => 'A senha atual é muito longa.',
            ]
        ],
        'senha_atual' => [
            'rules' => 'required|min_length[8]|max_length[256]',
            'errors' => [
                'required' => 'A senha atual é obrigatória.',
                'min_length' => 'A senha atual é muito curta.',
                'max_length' => 'A senha atual é muito longa.',
            ]
        ],
        'nova_senha' => [
            'rules' => 'permit_empty|min_length[8]|max_length[256]|differs[senha_atual]',
            'errors' => [
                'required' => 'Por favor, insira sua nova senha.',
                'min_length' => 'Sua nova senha é muito curta.',
                'max_length' => 'Sua nova senha é muito longa.',
                'differs' => 'Sua nova senha não pode ser igual a atual.',
            ]
        ],
        'confirmar_senha' => [
            'rules' => 'permit_empty|matches[nova_senha]',
            'errors' => [
                'required' => 'A confirmação da sua nova senha é obrigatória.',
                'matches' => 'A sua nova senha e a confirmação da mesma devem ser idênticas.',
            ]
        ]
    ];

    protected $helpers = ['misc_helper'];

    public $session;

    public function __construct() {
        $this->session = session();
    }

    public function index() {
        if(!$this->request->is('POST')) {
            $data = array();

            if(session()->get('tipo_usuario') === 'orgao_master') {
                $data['conta'] = 'orgao';
            } elseif (session()->get('tipo_usuario') === 'orgao_representante') {
                $data['conta'] = 'representante';
            } elseif (session()->get('tipo_usuario') === 'admin') {
                $data['conta'] = 'admin';
            }

            return view('usuarios', $data);
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


    public function upsert_orgao($operacao, $idUsuario = null) {

        if(!$this->request->is('POST') && !$this->request->is('AJAX')) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'O tipo da requisição é inválido.'
            ]);
        }

        $idOrgao = intval(session()->get('id_orgao'));

        if (!$idOrgao) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sessão expirada ou inválida.'
            ]);
        }

        $op = null;
        if ($operacao === 'cadastrar-usuario') {
            $op = 'cadastrar';
        } else if ($operacao === 'editar-usuario') {
            $op = 'editar';
        } else {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'A permissão do usuário é inválida.'
            ]);
        }

        // Inicializa a conexão com o banco de dados para transações
        $db = \Config\Database::connect();
        $builder = $db->table('usuarios');

        if ($op === 'editar') {
            if (empty($idUsuario)) {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'O Usuário que você está tentando editar não existe.'
                ]);
            }

            $usuarioExistente = null;
            # Recupera o e-mail do usuário com base no ID
            $usuarioExistente = $builder
                ->select('id_usuario, user_uuid, nome_completo, email, senha, tipo_usuario, id_orgao_fk, ativo, data_criacao, data_edicao')
                ->where('id_usuario', $idUsuario)
                ->get()
                ->getRowArray();

            // log_message('info', json_encode($usuarioExistente, JSON_PRETTY_PRINT));
        }

        $data = $this->request->getPost();

        $dadosUsuario = array();
        $dadosUsuario = [
            'nome_completo' => uniformiza_string($data['nome_completo']),
            'tipo_usuario'  => $data['permissao'],
            'id_orgao_fk'   => $idOrgao,
            'ativo'         => $data['status'],
            'id_orgao_fk'   => session()->get('id_orgao'),
        ];

        if (isset($usuarioExistente) && !empty($usuarioExistente)) {
            $dadosUsuario['email'] = $usuarioExistente['email'];
            $dadosUsuario['id_usuario'] = $usuarioExistente['id_usuario'];
            $dadosUsuario['user_uuid'] = $usuarioExistente['user_uuid'];
            $dadosUsuario['senha'] = $usuarioExistente['senha'];
            $dadosUsuario['data_criacao'] = $usuarioExistente['data_criacao'];
            $dadosUsuario['data_edicao'] = $usuarioExistente['data_edicao'];
        } else {
            $dadosUsuario['email'] = mb_strtolower(uniformiza_string($data['email']));
        }

        if (!empty($idUsuario)) {
            $found_diff = false;
            foreach($usuarioExistente as $key => $value) {
                if($dadosUsuario[$key] != $value) {
                    $log['user_action']['reg_id'] = $idUsuario;
                    $log['user_action'][mb_strtolower($key)] = [esc($value), esc($dadosUsuario[$key])];
                    $found_diff = true;
                }
            }
            # Se não houve nenhuma mudança, retorna uma mensagem de erro e sinaliza ao usuário.
            if (!$found_diff) {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Os novos dados do usuário não podem permanecer iguais aos antigos. Realize ao menos uma alteração para atualizar o usuário.'
                ]);
            }
        }

        # CodeIgniter Validation
        $errors = [];
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules($this->regrasUsuarioOrgao);
        $validated = $validation->run($dadosUsuario);

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

        $usuarioModel = new UsuarioModel();

        $db->transStart();

        switch ($operacao) {

            case 'cadastrar-usuario':
                # Verifica se o e-mail recebido do formulário já existe no banco:
                $validEmail = $usuarioModel->findUserByEmail($dadosUsuario['email']);

                if(!empty($validEmail[0])) {
                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'O E-mail informado já possui cadastro.'
                    ]);
                }

                try {
                    $dadosUsuario['user_uuid'] = $usuarioModel->generateUUID();
                    $tempPassword = $usuarioModel->passwordGenerator();
                    $dadosUsuario['senha'] = $tempPassword;
                    $dadosUsuario['senha'] = password_hash($dadosUsuario['senha'], PASSWORD_BCRYPT);

                    if(!$usuarioModel->inserirUsuario($dadosUsuario)) {
                        log_message('error', "Falha ao cadastrar usuário: " . json_encode($usuarioModel->errors()));
                        $db->transRollback();

                        return $this->response->setJSON([
                            'status' => 'error', 
                            'message' => "Algo deu errado ao cadastrar o usuário. Por favor, tente novamente."
                        ]);
                    }

                    if ($db->transStatus() === false) {
                        $db->transRollback();
                        return $this->response->setJSON([
                            'status' => 'error', 
                            'message' => 'Falha ao efetivar o cadastro. Por favor, tente novamente em alguns instantes.'
                        ]);
                    }
                    
                } catch(\Exception $e) {
                    log_message('error', '[EDIÇÃO USUARIO] Exceção: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
                    if ($db->transStatus() === true) {
                        $db->transRollback();
                    }

                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'Uma falha interna impediu o cadastro do usuário atual. Entre em contato com um administrador.'
                    ]);
                }
                
                break;


            case 'editar-usuario':
                try {

                    $dadosUsuario['data_edicao'] = date('Y-m-d H:i:s');

                    if(!$usuarioModel->editarUsuario($idUsuario, $dadosUsuario)) {
                        log_message('error', "Falha ao editar usuário: " . json_encode($usuarioModel->errors()));
                        $db->transRollback();

                        return $this->response->setJSON([
                            'status' => 'error', 
                            'message' => "Algo deu errado ao editar o usuário. Por favor, tente novamente."
                        ]);
                    }

                    if ($db->transStatus() === false) {
                        $db->transRollback();
                        return $this->response->setJSON([
                            'status' => 'error', 
                            'message' => 'Algo deu errado ao efetivar a edição do usuário atual. Por favor, entre em contato com um administrador ou tente novamente mais tarde.'
                        ]);
                    }
                    
                } catch(\Exception $e) {
                    log_message('error', '[EDIÇÃO USUARIO] Exceção: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
                    if ($db->transStatus() === true) {
                        $db->transRollback();
                    }

                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'Uma falha interna impediu a edição do usuário atual. Entre em contato com um administrador.'
                    ]);
                }

                break;

        }

        $db->transCommit();

        if ($op === 'editar') {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON([
                'status' => 'success', 
                'data' => $tempPassword,
            ]);
        }
    }

    public function exibir_perfil($uuid) {

        if ($uuid !== session()->get('uuid')) {
            return redirect()->to('/usuario/perfil/' . $uuid);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('usuarios');

        $usuarioExistente = null;
        # Recupera o e-mail do usuário com base no ID
        $usuarioExistente = $builder
            ->select('id_usuario, user_uuid, nome_completo, email, senha, tipo_usuario, id_orgao_fk, ativo, data_criacao, data_edicao')
            ->where('user_uuid', $uuid)
            ->get()
            ->getRowArray();

        if (!$this->request->is('POST') && !$this->request->is('AJAX')) {
            if(session()->get('tipo_usuario') === 'orgao_master') {
                $usuarioExistente['conta'] = 'orgao';
            } elseif (session()->get('tipo_usuario') === 'orgao_representante') {
                $usuarioExistente['conta'] = 'representante';
            } elseif (session()->get('tipo_usuario') === 'admin') {
                $usuarioExistente['conta'] = 'admin';
            } else {
                $usuarioExistente['conta'] = 'cidadao';
            }

            return view('perfil-usuario', $usuarioExistente);
        }

        unset($usuarioExistente['conta']);

        $data = $this->request->getPost();

        $dadosUsuario = array();
        $dadosUsuario = [
            'nome_completo'   => uniformiza_string($data['nome_completo']),
            'email'           => mb_strtolower(uniformiza_string($data['email'])),
            'senha_atual'     => $data['senhaAtual'],
            'nova_senha'      => $data['novaSenha'],
            'confirmar_senha' => $data['confirmarSenha'],
        ];

        if (isset($usuarioExistente) && !empty($usuarioExistente)) {
            $dadosUsuario['senha'] = $dadosUsuario['nova_senha'];
            $dadosUsuario['id_usuario'] = $usuarioExistente['id_usuario'];
            $dadosUsuario['user_uuid'] = $usuarioExistente['user_uuid'];
            $dadosUsuario['data_criacao'] = $usuarioExistente['data_criacao'];
            $dadosUsuario['data_edicao'] = $usuarioExistente['data_edicao'];
            $dadosUsuario['tipo_usuario'] = $usuarioExistente['tipo_usuario'];
            $dadosUsuario['id_orgao_fk'] = $usuarioExistente['id_orgao_fk'];
            $dadosUsuario['ativo'] = $usuarioExistente['ativo'];


            $idUsuario = $usuarioExistente['id_usuario'];
        } else {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Seu usuário não foi encontrado no sistema.'
            ]);
        }

        if (!empty($idUsuario)) {
            $found_diff = false;
            foreach($usuarioExistente as $key => $value) {
                if($dadosUsuario[$key] != $value) {
                    $log['user_action']['reg_id'] = $idUsuario;
                    $log['user_action'][mb_strtolower($key)] = [esc($value), esc($dadosUsuario[$key])];
                    $found_diff = true;
                }
            }
            # Se não houve nenhuma mudança, retorna uma mensagem de erro e sinaliza ao usuário.
            if (!$found_diff) {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Seus novos dados não podem permanecer iguais aos antigos. Realize ao menos uma alteração para atualizar seu cadastro.'
                ]);
            }
        }

        if (!empty($dadosUsuario['nova_senha'])) {
            
            # Se não houve nenhuma mudança, retorna uma mensagem de erro e sinaliza ao usuário.
            if (!$found_diff) {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Seus novos dados não podem permanecer iguais aos antigos. Realize ao menos uma alteração para atualizar seu cadastro.'
                ]);
            }
        }

        # CodeIgniter Validation
        $errors = [];
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules($this->regrasAtualizacaoUsuario);
        $validated = $validation->run($dadosUsuario);

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

        $usuarioModel = new UsuarioModel();

        $db->transStart();

        try {

            if (!password_verify($dadosUsuario['senha_atual'], $usuarioExistente['senha'])) {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => "Sua senha atual está incorreta."
                ]);
            }

            if (!empty($dadosUsuario['nova_senha'])) {
                $dadosUsuario['senha'] = password_hash($dadosUsuario['nova_senha'], PASSWORD_BCRYPT);
                unset($dadosUsuario['senha_atual']);
                unset($dadosUsuario['nova_senha']);
                unset($dadosUsuario['confirmar_senha']);
            }

            $dadosUsuario['data_edicao'] = date('Y-m-d H:i:s');

            if(!$usuarioModel->editarUsuario($idUsuario, $dadosUsuario)) {
                log_message('error', "Falha ao editar usuário: " . json_encode($usuarioModel->errors()));
                $db->transRollback();

                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => "Algo deu errado ao editar o usuário. Por favor, tente novamente."
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Algo deu errado ao efetivar a edição do seu cadastro. Por favor, entre em contato com um administrador ou tente novamente mais tarde.'
                ]);
            }
            
        } catch(\Exception $e) {
            log_message('error', '[EDIÇÃO USUARIO] Exceção: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            if ($db->transStatus() === true) {
                $db->transRollback();
            }

            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Uma falha interna impediu a edição do seu cadastro. Entre em contato com um administrador.'
            ]);
        }

        $db->transCommit();

        return $this->response->setJSON([
            'status' => 'success',
        ]);

    }
}
