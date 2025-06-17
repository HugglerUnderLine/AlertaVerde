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

    public function index($uuid = null) {
        if(session()->get('tipo_usuario') === 'orgao_master') {
            $data['conta'] = 'orgao';
            if(!empty($uuid)) {
                $data['url_destino'] = base_url("painel/orgao/usuario/$uuid/log/list");
            } else {
                $data['url_destino'] = base_url("painel/orgao/usuarios/log/list");
            }
        } elseif (session()->get('tipo_usuario') === 'orgao_representante') {
            $data['conta'] = 'representante';
            if(!empty($uuid)) {
                $data['url_destino'] = base_url("painel/orgao/usuario/$uuid/log/list");
            } else {
                $data['url_destino'] = base_url("painel/orgao/usuarios/log/list");
            }
        } elseif (session()->get('tipo_usuario') === 'admin') {
            $data['conta'] = 'admin';
            if(!empty($uuid)) {
                $data['url_destino'] = base_url("painel/admin/usuario/$uuid/log/list");
            } else {
                $data['url_destino'] = base_url("painel/admin/usuarios/log/list");
            }
        }

        if(!empty($uuid)) {
            $db = \Config\Database::connect();
            $builder = $db->table('usuarios');

            $usuarioExistente = null;
            # Recupera os dados do usuário com base no UUID
            $usuarioExistente = $builder
                ->select('id_usuario, user_uuid, nome_completo, email, senha, tipo_usuario, id_orgao_fk, ativo, data_criacao, data_edicao')
                ->where('user_uuid', $uuid)
                ->get()
                ->getRowArray();

            $data['nome_usuario'] = $usuarioExistente['nome_completo'];
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
            'dataInicial' => strval($this->request->getPost('filtroDataInicial')),
            'dataFinal' => strval($this->request->getPost('filtroDataFinal'))
        ];

        // log_message('info', json_encode($vars, JSON_PRETTY_PRINT));

        if (!empty($uuid)) {
            $vars['uuid'] = $uuid;
        }

        $cols = ['user_email', 'nome_orgao', 'tipo_usuario', 'user_action', 'user_ip', 'detalhes', 'data_log'];

        $logAuditoriaModel = new LogAuditoriaModel();

        $total = $logAuditoriaModel->builder()->countAllResults();

        [$data, $recordsFiltered] = $logAuditoriaModel->complexGetLog($vars, $cols);

        // Garante que cada linha esteja no formato que o DataTables entende
        $formattedData = array_map(function($item) {
            return [
                'user_email' => $item['user_email'],
                'nome_orgao' => $item['nome_orgao'],
                'tipo_usuario' => $item['tipo_usuario'],
                'user_action' => $item['user_action'],
                'user_ip' => $item['user_ip'],
                'detalhes' => $item['detalhes'],
                'data_log' => $item['data_log'],
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
