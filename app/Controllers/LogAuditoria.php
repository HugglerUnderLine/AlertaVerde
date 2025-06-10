<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAuditoriaModel;
use App\Models\OrgaoModel;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class LogAuditoria extends BaseController
{
    protected $helpers = ['misc_helper'];

    public $session;

    public function __construct() {
        $this->session = session();
    }

    public function index() {
        if(session()->get('tipo_usuario') === 'orgao_master') {
            $data['conta'] = 'orgao';
            $data['url_destino'] = base_url("painel/orgao/usuarios/log/list");
        } elseif (session()->get('tipo_usuario') === 'orgao_representante') {
            $data['conta'] = 'representante';
            $data['url_destino'] = base_url("painel/orgao/usuarios/log/list");
        } elseif (session()->get('tipo_usuario') === 'admin') {
            $data['conta'] = 'admin';
            $data['url_destino'] = base_url("painel/admin/usuarios/log/list");
        }

        return view('log-auditoria', $data);
    }

    public function log_usuario($uuid = null) {
        if (!$this->request->is('AJAX')) {
            return;
        }

        // DataTables default parameters
        $vars = [
            'draw' => strval($this->request->getPost('draw')),
            'start' => strval($this->request->getPost('start')),
            'length' => strval($this->request->getPost('length')),
            'order' => $this->request->getPost('order'),
            'email' => mb_strtolower(uniformiza_string($this->request->getPost('filtroEmail'))),
            'dataInicial' => strval($this->request->getPost('dataInicial')),
            'dataFinal' => strval($this->request->getPost('dataFinal'))
        ];

        $cols = ['user_email', 'nome_orgao', 'tipo_usuario', 'user_action', 'user_ip', 'detalhes', 'data_log'];

        $logAuditoriaModel = new LogAuditoriaModel();

        $total = $logAuditoriaModel->builder()->countAllResults();

        [$data, $recordsFiltered] = $logAuditoriaModel->complexGetLog($vars, $cols);

        // Garante que cada linha esteja no formato que o DataTables entende
        $formattedData = array_map(function($item) {
            return [
                'email' => $item['user_email'],
                'nomeOrgao' => $item['nome_orgao'],
                'permissao' => $item['tipo_usuario'],
                'user_action' => $item['user_action'],
                'IP' => $item['user_ip'],
                'detalhes' => $item['detalhes'],
                'dataLog' => $item['data_log'],
            ];
        }, $data);

        $jsonResponse = [
            'draw' => intval($vars['draw']),
            'recordsTotal' => $total,
            'recordsFiltered' => $recordsFiltered,
            'data' => $formattedData
        ];

        return $this->response->setJSON($jsonResponse);
    }

}
