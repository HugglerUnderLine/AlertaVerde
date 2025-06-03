<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DenunciaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Denuncia extends BaseController
{
    protected $helpers = ['misc_helper'];

    public $session;

    public function __construct() {
        $this->session = session();
    }

    public function index($tipoConta = null) {
        if(!$this->request->is('POST')) {
            return view('dashboard-'.$tipoConta);
        }
    }

    public function nova_denuncia() {
        // if(!$this->request->is('POST')) {
        //     return view('nova-denuncia');
        // }
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
            'id_orgao' => session('id_orgao'),
        ];

        $vars['titulo'] = !empty($this->request->getPost('titulo')) ? uniformiza_string($this->request->getPost('titulo')) : null;

        // log_message('info', json_encode($vars, JSON_PRETTY_PRINT));
        $denunciaModel = new DenunciaModel();

        # Colunas utilizadas no Datatables (usados para sorting na base)
        $cols = ['', 'titulo_denuncia', 'categoria', 'status', 'nome_completo', 'id_denuncia', 'id_usuario', 'id_tipo', 'detalhes', 'logradouro', 'numero', 'bairro', 'cep', 'ponto_referencia', 'id_orgao_responsavel_fk', 'data_submissao', 'data_atribuicao', 'data_conclusao', 'acoes'];

        // log_message('info', json_encode($cols, JSON_PRETTY_PRINT));

        $array4json = array();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $denunciaModel->builder()->countAllResults();

        [$array4json['data'], $array4json['recordsFiltered']] = $denunciaModel->complexGetDenuncias($vars, $cols);

        // log_message('info', json_encode($array4json, JSON_PRETTY_PRINT));

        return json_encode($array4json, JSON_PRETTY_PRINT);

    }
}
