<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DenunciaModel;
use App\Models\MidiaDenunciaModel;
use App\Models\OrgaoTipoDenunciaAtuacaoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Orgao extends BaseController
{
    protected $helpers = ['misc_helper'];

    public $session;

    public function __construct() {
        $this->session = session();
    }


    public function index()
    {
        if(!$this->request->is('POST')) {
            $idOrgaoLogado = session()->get('id_orgao'); // Pega o ID do órgão da sessão

            $denunciaModel = new DenunciaModel();
            $estatisticasDenuncias = $denunciaModel->getEstatisticasDenunciasOrgao((int) $idOrgaoLogado);

            log_message('info', json_encode($estatisticasDenuncias, JSON_PRETTY_PRINT));

            $dataView = [
                'stats' => $estatisticasDenuncias,
            ];
            
            // log_message('debug', 'Estatísticas para View: ' . json_encode($estatisticasDenuncias));

            return view('dashboard-orgao', $dataView);

        }
    }


    public function dados_graficos() {
        $orgaoId = session('id_orgao');
        $denunciaModel = new DenunciaModel();

        // Contagem por status
        $statusData = $denunciaModel
            ->select('status_denuncia as status, COUNT(*) as total')
            ->where('id_orgao_responsavel_fk', $orgaoId)
            ->groupBy('status_denuncia')
            ->findAll();

        // log_message('info', $denunciaModel->getLastQuery());

        // Contagem por categoria (JOIN para obter o nome da categoria)
        $categoriaData = $denunciaModel
            ->select('tipo_denuncia.categoria, COUNT(*) as total')
            ->join('tipo_denuncia', 'tipo_denuncia.id_tipo = denuncias.id_tipo_fk')
            ->where('id_orgao_responsavel_fk', $orgaoId)
            ->groupBy('tipo_denuncia.categoria')
            ->findAll();

        // log_message('info', $denunciaModel->getLastQuery());

        return $this->response->setJSON([
            'status' => $statusData,
            'categorias' => $categoriaData
        ]);
    }


    public function denuncias_enviadas() {

        if (!$this->request->is('POST')) {
            $orgaoID = intval(session()->get('id_orgao'));

            $denunciaModel = new DenunciaModel();
            $midiaModel = new MidiaDenunciaModel();

            $data['denuncia'] = $denunciaModel->getDenunciasDoOrgao($orgaoID);

            # Extração dos IDs das denúncias
            $idsDenuncias = array_column($data['denuncia'], 'id_denuncia');

            # Busca as mídias associadas
            $midiasAgrupadas = $midiaModel->getMidiasByDenuncias($idsDenuncias);

            # Associa as mídias às respectivas denúncias
            foreach ($data['denuncia'] as &$denuncia) {
                $id = $denuncia['id_denuncia'];
                $denuncia['midias'] = $midiasAgrupadas[$id] ?? [];

                # Formata a data e endereço
                $datetime = \CodeIgniter\I18n\Time::parse($denuncia['data_submissao'], 'America/Sao_Paulo', 'pt_BR');
                $denuncia['tempo'] = $datetime->humanize();
                $denuncia['endereco'] = $denuncia['logradouro'] . ", " . $denuncia['numero'] . " - " . $denuncia['bairro'];
            }

            // log_message('info', json_encode($data, JSON_PRETTY_PRINT));

            return view('dashboard-orgao-denuncia', $data);
        }
    }

    public function listar_midias($id_denuncia) {
        $caminhoBase = FCPATH . 'uploads/denuncias/' . $id_denuncia;
        $urlBase = base_url('uploads/denuncias/' . $id_denuncia);

        $imagens = [];
        $videos = [];

        if (is_dir($caminhoBase)) {
            $arquivos = scandir($caminhoBase);

            foreach ($arquivos as $arquivo) {
                if (in_array(strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $imagens[] = $urlBase . '/' . $arquivo;
                }

                if (in_array(strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)), ['mp4', 'webm', 'ogg'])) {
                    $videos[] = $urlBase . '/' . $arquivo;
                }
            }
        }

        return $this->response->setJSON([
            'imagens' => $imagens,
            'videos'  => $videos
        ]);
    }



}
