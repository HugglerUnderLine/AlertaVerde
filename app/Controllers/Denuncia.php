<?php

/*
* DEUS ME PERDOE PELO QUE EU FIZ NESSE PROJETO *
*/

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DenunciaModel;
use App\Models\LogAuditoriaModel;
use App\Models\MidiaDenunciaModel;
use App\Models\TipoDenunciaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Denuncia extends BaseController
{
    protected $helpers = ['misc_helper'];
    public $session;

    # Regras de validação de formulário do CodeIgniter
    protected $regrasDenuncia = [
        'titulo_denuncia' => [
            'rules' => 'required|min_length[5]|max_length[150]',
            'errors' => [
                'required' => 'O Título da denúncia deve ser preenchido',
                'min_length' => 'O Título da denúncia informado é muito curto.',
                'max_length' => 'O Título da denúncia informado é muito longo.',
            ]
        ],
        'id_tipo_fk' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'A Categoria da denúncia deve ser preenchida.',
            ]
        ],
        'detalhes' => [
            'rules' => 'required|min_length[10]|max_length[4000]',
            'errors' => [
                'required' => 'A Descrição da denúncia deve ser preenchida.',
                'min_length' => 'A Descrição da denúncia informada muito curta',
                'max_length' => 'A Descrição da denúncia informada muito longa.',
            ]
        ],
        'logradouro' => [
            'rules' => 'required|min_length[8]|max_length[150]',
            'errors' => [
                'required' => 'O Logradouro deve ser preenchido.',
                'min_length' => 'O Logradouro informado é muito curto.',
                'max_length' => 'O Logradouro informado é muito longo.',
            ]
        ],
        'numero' => [
            'rules' => 'required|min_length[1]|max_length[6]',
            'errors' => [
                'required' => 'O Número deve ser preenchido.',
                'min_length' => 'O Número informado é muito curto.',
                'max_length' => 'O Número informado é muito longo.',
            ],
        ],
        'bairro' => [
            'rules' => 'required|min_length[5]|max_length[125]',
            'errors' => [
                'required' => 'O Bairro deve ser preenchido.',
                'min_length' => 'O Bairro informado é muito curto.',
                'max_length' => 'O Bairro informado é muito longo.',
            ]
        ],
        'cep' => [
            'rules' => 'required|min_length[9]|max_length[9]',
            'errors' => [
                'required' => 'O CEP deve ser preenchido.',
                'min_length' => 'O CEP informado é muito curto.',
                'max_length' => 'O CEP informado é muito longo.',
            ]
        ],
        'ponto_referencia' => [
            'rules' => 'max_length[150]',
            'errors' => [
                'max_length' => 'O Ponto de Referência informado é muito longo.',
            ]
        ],
    ];


    public function __construct() {
        $this->session = session();
    }


    public function index() {
        //
    }


    public function nova_denuncia() {

        if (!$this->request->is('POST')) {
            return redirect()->to(base_url('painel/cidadao'));
        }

        $data = $this->request->getPost();
        $midia = $this->request->getFiles();

        // log_message('info', json_encode($data, JSON_PRETTY_PRINT));
        // log_message('info', json_encode($imgFiles, JSON_PRETTY_PRINT));

        $novaDenuncia  = [];
        $midiaDenuncia = [];

        $novaDenuncia = [
            'titulo_denuncia'  => uniformiza_string($data['titulo_denuncia']),
            'id_tipo_fk'       => intval($data['categoria_denuncia']),
            'detalhes'         => uniformiza_espacos($data['descricao_denuncia']),
            'logradouro'       => uniformiza_string($data['logradouro_denuncia']),
            'numero'           => uniformiza_espacos($data['numero_denuncia']),
            'bairro'           => uniformiza_string($data['bairro_denuncia']),
            'cep'              => uniformiza_espacos($data['cep_denuncia']),
            'ponto_referencia' => uniformiza_string($data['ponto_referencia']),
            'status_denuncia'  => 'Pendente',
        ];

        if (isset($midia['imagens_denuncia']) && !empty($midia['imagens_denuncia'])) {
            $midiaDenuncia['imagens_denuncia'] = $midia['imagens_denuncia'];
        }
        if (isset($midia['video_denuncia']) && !empty($midia['video_denuncia'])) {
            $midiaDenuncia['video_denuncia'] = $midia['video_denuncia'];
        }

        // log_message('info', json_encode($novaDenuncia, JSON_PRETTY_PRINT));
        // log_message('info', json_encode($midiaDenuncia, JSON_PRETTY_PRINT));

        # CodeIgniter Validation
        $errors = [];
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules($this->regrasDenuncia);

        $validated = $validation->run($novaDenuncia);

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

        $logAuditoriaModel = new LogAuditoriaModel();
        $log = [
            'user_action'        => 'cadastrar-denuncia',
            'user_email'         => session('email'),
            'user_ip'            => $this->request->getIPAddress(),
            'user_uuid'          => session('uuid'),
            'user_nome_completo' => session('nome_completo'),
            'id_orgao'           => session('id_orgao'),
            'tipo_usuario'       => session('tipo_usuario'),
        ];

        $tipoDenunciaModel = new TipoDenunciaModel();
        $tipoValido = $tipoDenunciaModel->getTiposDenuncia($novaDenuncia['id_tipo_fk']);

        if (empty($tipoValido) || $tipoValido['id_tipo'] != $novaDenuncia['id_tipo_fk']) {
            $log['detalhes'] = json_encode(['status' => 'erro', 'motivo' => 'A Categoria da denúncia informada é inválida.']);
            $logAuditoriaModel->insert($log);
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'A Categoria da denúncia informada é inválida.'
            ]);
        }

        # Inicializa a conexão com o banco de dados para transações
        $db = \Config\Database::connect();

        try {
            $arquivosFisicosMovidos = [];

            $idUsuarioLogado = session('id_usuario');
            if (!$idUsuarioLogado) {
                throw new \Exception("Usuário não autenticado.");
            }

            $novaDenuncia['id_usuario_fk'] = session('id_usuario');

            $denunciaModel = new DenunciaModel();
            $midiaDenunciaModel = new MidiaDenunciaModel();

            # Inicia transação para a denúncia apenas
            $db->transStart();

            $denunciaID = $denunciaModel->inserirDenuncia($novaDenuncia);

            if (!$denunciaID) {
                throw new \Exception('Falha ao inserir denúncia.');
            }

            $db->transCommit(); // Confirma somente a denúncia

            if (!$denunciaID || !is_numeric($denunciaID)) {
                log_message('error', '[NOVA DENUNCIA] ID inválido após insert. Valor: ' . var_export($denunciaID, true));
            } else {
                log_message('info', '[NOVA DENUNCIA] ID denúncia inserido com sucesso: ' . $denunciaID);
                $existe = $denunciaModel->find($denunciaID);
                if (!$existe) {
                    log_message('error', '[NOVA DENUNCIA] ERRO: A denúncia com id ' . $denunciaID . ' não existe após insert!');
                }
            }


            $db->transStart(); // Inicia a transação para as imagens e vídeos

            # Processamento das Imagens
            if (isset($midiaDenuncia['imagens_denuncia'])) {
                // log_message('debug', 'Processando imagens_denuncia. Quantidade de arquivos no array: ' . count($midiaDenuncia['imagens_denuncia']));

                $imagens = $midiaDenuncia['imagens_denuncia'] ?? [];
                if (!is_array($imagens)) {
                    $imagens = [$imagens];
                }

                foreach ($midiaDenuncia['imagens_denuncia'] as $imgFile) {
                    // Verifica se é um objeto UploadedFile válido
                    if ($imgFile instanceof \CodeIgniter\HTTP\Files\UploadedFile && $imgFile->isValid()) { 

                        if (!$imgFile->hasMoved()) {
                            $subdiretorioDenuncia = 'uploads' . DIRECTORY_SEPARATOR . 'denuncias' . DIRECTORY_SEPARATOR . $denunciaID;
                            $diretorioUpload = FCPATH . $subdiretorioDenuncia;

                            
                            if (!is_dir($diretorioUpload)) {
                                if (!mkdir($diretorioUpload, 0775, true)) {
                                    // log_message('error', "Falha ao criar diretório: " . $diretorioUpload);
                                    throw new \Exception("Não foi possível criar o diretório para as mídias.");
                                }
                            }
                            
                            $novoNomeImagem = $imgFile->getRandomName();
                            $caminhoCompletoImagem = $diretorioUpload . DIRECTORY_SEPARATOR . $novoNomeImagem;
                            // log_message('debug', "Tentando mover imagem '{$imgFile->getName()}' para '{$diretorioUpload}/{$novoNomeImagem}'");

                            if ($imgFile->move($diretorioUpload, $novoNomeImagem)) {
                                log_message('info', "Imagem movida com sucesso: {$diretorioUpload}/{$novoNomeImagem}");
                                $arquivosFisicosMovidos[] = $caminhoCompletoImagem;

                                $currMidia = array();

                                $currMidia = [
                                    'id_denuncia_fk'  => intval($denunciaID),
                                    'tipo_midia'      => 'foto',
                                    'caminho_arquivo' => $subdiretorioDenuncia . DIRECTORY_SEPARATOR . $novoNomeImagem,
                                ];

                                // log_message('info', json_encode($currMidia, JSON_PRETTY_PRINT));

                                $isInserted = $midiaDenunciaModel->inserirMidia($currMidia);

                                if ($isInserted === false) {
                                    log_message('error', "Falha ao registrar mídia no DB. ");
                                    throw new \Exception("Não foi possível cadastrar a mídia na base de dados.");
                                }

                            } else {
                                log_message('error', 'Falha ao MOVER imagem: ' . $imgFile->getErrorString().' ('.$imgFile->getError().')');
                                throw new \Exception("Falha ao processar upload de imagem.");
                            }
                        } else {
                            log_message('debug', "Imagem '{$imgFile->getName()}' já foi movida ou não é válida para mover.");
                        }
                    } else {
                        # Log se um item no array 'imagens_denuncia' não for um arquivo válido
                        log_message('warning', 'Item inválido encontrado no array de imagens_denuncia.');
                    }
                }
            } else {
                log_message('debug', 'Nenhum arquivo encontrado em "imagens_denuncia".');
            }
            
            # Processamento do VÍDEO
            if (isset($midiaDenuncia['video_denuncia']) && $midiaDenuncia['video_denuncia'] instanceof \CodeIgniter\HTTP\Files\UploadedFile) {
                $arquivoVideo = $midiaDenuncia['video_denuncia'];
                if ($arquivoVideo->isValid() && !$arquivoVideo->hasMoved()) {

                    $subdiretorioDenuncia = 'uploads' . DIRECTORY_SEPARATOR . 'denuncias' . DIRECTORY_SEPARATOR . $denunciaID;
                    $diretorioUpload = FCPATH . $subdiretorioDenuncia;

                     if (!is_dir($diretorioUpload)) {
                        if (!mkdir($diretorioUpload, 0775, true)) {
                            log_message('error', "Falha ao criar diretório para vídeo: " . $diretorioUpload);
                            throw new \Exception("Não foi possível criar o diretório para as mídias.");
                        }
                    }
                    $novoNomeVideo = $arquivoVideo->getRandomName();
                    $caminhoCompletoVideo = $diretorioUpload . DIRECTORY_SEPARATOR . $novoNomeVideo;
                    log_message('debug', "Tentando mover vídeo '{$arquivoVideo->getName()}' para '{$diretorioUpload}/{$novoNomeVideo}'");

                    if ($arquivoVideo->move($diretorioUpload, $novoNomeVideo)) {
                        log_message('info', "Vídeo movido com sucesso: {$diretorioUpload}/{$novoNomeVideo}");
                        $arquivosFisicosMovidos[] = $caminhoCompletoVideo;
                        
                        $currMidia = array();

                        $currMidia = [
                            'id_denuncia_fk' => intval($denunciaID),
                            'tipo_midia'     => 'video',
                            'caminho_arquivo'=> $subdiretorioDenuncia . DIRECTORY_SEPARATOR . $novoNomeVideo,
                        ];

                        // log_message('info', json_encode($currMidia, JSON_PRETTY_PRINT));

                        $isInserted = $midiaDenunciaModel->inserirMidia($currMidia);

                        if ($isInserted === false) {
                            log_message('error', "Falha ao registrar mídia no DB. ");
                            throw new \Exception("Não foi possível cadastrar a mídia na base de dados.");
                        }

                    } else {
                        log_message('error', 'Falha ao MOVER vídeo: ' . $arquivoVideo->getErrorString().' ('.$arquivoVideo->getError().')');
                        throw new \Exception("Falha ao processar upload de vídeo.");
                    }
                } else if ($arquivoVideo->isValid() && $arquivoVideo->hasMoved()){
                    log_message('debug', "Vídeo '{$arquivoVideo->getName()}' já foi movido.");
                } else if (!$arquivoVideo->isValid()){
                    log_message('debug', "Vídeo '{$arquivoVideo->getName()}' não é válido. Erro: ".$arquivoVideo->getErrorString());
                }
            } else {
                log_message('debug', 'Nenhum arquivo encontrado em "video_denuncia".');
            }

            if (!$db->transStatus()) {
                throw new \Exception('Falha na transação ao salvar a denúncia e mídias.');
            }

            $db->transCommit();
            $log['detalhes'] = json_encode(['status' => 'sucesso']);
            $logAuditoriaModel->insert($log);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Denúncia registrada com sucesso!']);

        } catch (\Throwable $e) { // Throwable para pegar Errors e Exceptions
            log_message('error', '[NOVA DENUNCIA TRY-CATCH] Exceção: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            if (!empty($denunciaID)) {
                log_message('info', 'Removendo denúncia registrada devido a falha nas mídias.');
                $denunciaModel->where('id_denuncia', $denunciaID)->delete();
            }

            if ($db->transStatus()) {
                $db->transRollback();
            }

            if (!empty($arquivosFisicosMovidos)) {
                log_message('info', 'Iniciando rollback de arquivos físicos devido a erro na operação.');
                foreach ($arquivosFisicosMovidos as $caminhoArquivo) {
                    if (is_file($caminhoArquivo)) {
                        if (unlink($caminhoArquivo)) {
                            log_message('info', 'Arquivo de rollback deletado: ' . $caminhoArquivo);
                        } else {
                            log_message('error', 'Falha ao deletar arquivo de rollback: ' . $caminhoArquivo);
                        }
                    }
                }
            }

            $userMessage = 'Ocorreu um erro interno ao processar sua denúncia. Por favor, tente novamente.';
            return $this->response->setJSON(['status' => 'error', 'message' => $userMessage]);
        }
            
    }


    public function json_list() {

        if(!$this->request->is('AJAX')) {
            return;
        }

        $vars = array();
        # Parâmetros padrão e filtros do Datatables
        $vars = [
            'draw'     => strval($this->request->getPost('draw')),
            'start'    => strval($this->request->getPost('start')),
            'length'   => strval($this->request->getPost('length')),
            'order'    => $this->request->getPost('order'),
            'status'   => uniformiza_string($this->request->getPost('status')),
            'coluna_busca' => $this->request->getPost('coluna_busca'),
            'id_orgao' => intval(session('id_orgao')),
        ];

        $vars['titulo'] = !empty($this->request->getPost('titulo')) ? uniformiza_string($this->request->getPost('titulo')) : null;

        if (!empty($vars['coluna_busca'])) {
            if ($vars['coluna_busca'] === 'titulo') {
                $vars['titulo'] = uniformiza_string($this->request->getPost('valor_busca'));
            } else if ($vars['coluna_busca'] === 'categoria') {
                $vars['categoria'] = uniformiza_string($this->request->getPost('valor_busca'));
            }
        }

        // log_message('info', json_encode($vars['status']));

        if ($vars['status'] === 'PENDENTE' || $vars['status'] === 'EM PROGRESSO' || $vars['status'] === 'RESOLVIDO') {
            $vars['status'] = $vars['status'];
        } else {
            $vars['status'] = null;
        }

        // log_message('info', json_encode($vars, JSON_PRETTY_PRINT));
        $denunciaModel = new DenunciaModel();

        # Colunas utilizadas no Datatables (usados para sorting na base)
        $cols = ['', 'titulo_denuncia', 'categoria', 'status', 'nome_completo', 'id_denuncia', 'id_usuario', 'id_tipo', 'detalhes', 'logradouro', 'numero', 'bairro', 'cep', 'ponto_referencia', 'id_orgao_responsavel_fk', 'data_submissao', 'data_atribuicao', 'data_conclusao', 'acoes'];

        // log_message('info', json_encode($cols, JSON_PRETTY_PRINT));

        $array4json = array();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $denunciaModel->builder()->where('id_orgao_responsavel_fk', $vars['id_orgao'])->countAllResults();

        [$array4json['data'], $array4json['recordsFiltered']] = $denunciaModel->complexGetDenuncias($vars, $cols);

        // log_message('info', json_encode($array4json, JSON_PRETTY_PRINT));

        return json_encode($array4json, JSON_PRETTY_PRINT);

    }


    public function listar_denuncias_cidadao() {
        $model = new DenunciaModel();

        // log_message('info', $this->request->getLocale());

        $filtros = [
            'id_usuario' => session()->get('id_usuario'),
            'titulo'     => uniformiza_string($this->request->getPost('titulo')),
            'status'     => $this->request->getPost('status')
        ];

        // log_message('info', json_encode($filtros, JSON_PRETTY_PRINT));

        $dados = $model->getDenunciasDoUsuario($filtros);

        # Formata o tempo para o timestamp local
        foreach ($dados as &$denuncia) {
            $datetime = \CodeIgniter\I18n\Time::parse($denuncia['data'], 'America/Sao_Paulo', 'pt_BR');
            $denuncia['tempo'] = $datetime->humanize();
        }

        return $this->response->setJSON($dados);
    }


    public function listar_denuncias_form($idDenuncia) {
        $model = new DenunciaModel();
        $dados = $model->getDetalhesDenuncia($idDenuncia);
        $dados = $dados[0];

        // log_message('info', json_encode($dados, JSON_PRETTY_PRINT));
        return $this->response->setJSON($dados);
    }


    public function atribuir_denuncia() {

        $logAuditoriaModel = new LogAuditoriaModel();
        $log = [
            'user_action'        => 'atribuir-denuncia',
            'user_email'         => session('email'),
            'user_ip'            => $this->request->getIPAddress(),
            'user_uuid'          => session('uuid'),
            'user_nome_completo' => session('nome_completo'),
            'id_orgao'           => session('id_orgao'),
            'tipo_usuario'       => session('tipo_usuario'),
        ];

       if (!$this->request->is('AJAX') || !$this->request->is('POST')) {
            $log['detalhes'] = json_encode(['status' => 'erro', 'motivo' => 'Tipo de requisição inválido']);
            $logAuditoriaModel->insert($log);

            return $this->response->setJSON([
                'sucesso' => false,
                'mensagem' => 'O tipo da requisição é inválido!.'
            ]);
        }

        $idDenuncia = intval($this->request->getPost('id_denuncia'));

        if (empty($idDenuncia) || !is_numeric($idDenuncia)) {
            $log['detalhes'] = json_encode(['status' => 'erro', 'motivo' => 'ID da denúncia inválido.']);
            $logAuditoriaModel->insert($log);

            return $this->response->setJSON([
                'sucesso' => false,
                'mensagem' => 'ID da denúncia inválido.'
            ]);
        }

        $idUsuario = session()->get('id_usuario');
        $idOrgao = session()->get('id_orgao');

        if (!$idUsuario || !$idOrgao) {
            return $this->response->setJSON([
                'sucesso' => false,
                'mensagem' => 'Sessão expirada ou inválida.'
            ]);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('denuncias');

        try {
            $db->transBegin();

            # Verifica se a denúncia realmente existe e não tem órgão responsável ainda
            $denunciaExistente = $builder
                ->select('id_denuncia')
                ->where('id_denuncia', $idDenuncia)
                ->where('id_orgao_responsavel_fk IS NULL')
                ->get()
                ->getRow();

            if (!$denunciaExistente) {
                $db->transRollback();
                return $this->response->setJSON([
                    'sucesso' => false,
                    'mensagem' => 'Denúncia já atribuída ou inexistente.'
                ]);
            }

            # Atualiza a denúncia
            $builder
                ->where('id_denuncia', $idDenuncia)
                ->update([
                    'id_orgao_responsavel_fk' => $idOrgao,
                    'id_usuario_responsavel_fk' => $idUsuario,
                    'data_atribuicao' => date('Y-m-d H:i:s')
                ]);

            if ($db->affectedRows() !== 1) {
                $db->transRollback();
                return $this->response->setJSON([
                    'sucesso' => false,
                    'mensagem' => 'Algo deu errado ao atribuir a denúncia.'
                ]);
            }

            $db->transCommit();

            $log['detalhes'] = json_encode(['status' => 'sucesso']);
            $logAuditoriaModel->insert($log);

            return $this->response->setJSON([
                'sucesso' => true,
                'mensagem' => 'Denúncia atribuída com sucesso.'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Erro ao atribuir denúncia: ' . $e->getMessage());

            return $this->response->setJSON([
                'sucesso' => false,
                'mensagem' => 'Uma falha interna impediu a atribuição da denúncia. Por favor, tente novamente mais tarde.'
            ]);
        }
    }

    public function atualizar_status_denuncia() {
        $id = $this->request->getPost('denunciaID');
        $novoStatus = trim($this->request->getPost('novoStatus'));

        // log_message('info', json_encode(["ID" => $id, "NOVO STATUS" => $novoStatus], JSON_PRETTY_PRINT));

        if (!$id || $novoStatus === '') {
            return $this->response->setJSON([
                'status' => 'erro',
                'mensagem' => 'Parâmetros inválidos.'
            ]);
        }

        $valoresValidos = ['Pendente', 'Em Progresso', 'Resolvido'];
        if (!in_array($novoStatus, $valoresValidos)) {
            return $this->response->setJSON([
                'status' => 'erro',
                'mensagem' => 'Status inválido.'
            ]);
        }

        $denunciaModel = new DenunciaModel();
        if ($novoStatus === 'Resolvido') {
            $sucesso = $denunciaModel->update($id, ['status_denuncia' => $novoStatus, 'data_conclusao' => date('Y-m-d H:i:s')]);
        } else {
            $sucesso = $denunciaModel->update($id, ['status_denuncia' => $novoStatus]);
        }

        $logAuditoriaModel = new LogAuditoriaModel();
        $log = [
            'user_action'        => 'atualizar-status-denuncia',
            'user_email'         => session('email'),
            'user_ip'            => $this->request->getIPAddress(),
            'user_uuid'          => session('uuid'),
            'user_nome_completo' => session('nome_completo'),
            'id_orgao'           => session('id_orgao'),
            'tipo_usuario'       => session('tipo_usuario'),
        ];


        if ($sucesso) {
            $log['detalhes'] = json_encode(['status' => 'sucesso', 'registro' => $id]);
            $logAuditoriaModel->insert($log);
            return $this->response->setJSON([
                'status' => 'sucesso',
                'mensagem' => 'Status atualizado com sucesso.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'erro',
            'mensagem' => 'Falha ao atualizar o status.'
        ]);
    }


}
