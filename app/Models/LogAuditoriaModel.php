<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAuditoriaModel extends Model
{
    protected $table            = 'log_auditoria';
    protected $primaryKey       = 'log_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_uuid', 'user_email', 'user_nome_completo', 'tipo_usuario', 'user_action', 'user_ip', 'detalhes', 'data_log'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function complexGetLog($vars, $cols) {

        $sql_select = 'SELECT log_auditoria.user_email,
                              orgaos.id_orgao,
                              orgaos.nome_orgao,
                              usuarios.tipo_usuario,
                              usuarios.id_orgao_fk,
                              log_auditoria.user_action, 
                              log_auditoria.user_ip, 
                              log_auditoria.detalhes,
                              TO_CHAR(log_auditoria.data_log, \'DD-MM-YYYY HH24:MI\') AS data_log';
        
        $sql_from = "\nFROM log_auditoria";

        $sql_join = "\nJOIN usuarios ON usuarios.user_uuid = log_auditoria.user_uuid
                       JOIN orgaos ON usuarios.id_orgao_fk = orgaos.id_orgao";

        # Verifica se existe algum parâmetro relacionado ao filtro, e aplica no where
        $found_where = false;
        $where_params = array();
        if (isset($vars['uuid']) && !empty($vars['uuid'])) {
            $where_params[] = "log_auditoria.user_uuid = :uuid:";
            $found_where = true;
        }
        if (!empty($vars['email'])) {
            $where_params[] = "log_auditoria.user_email LIKE :email:";
            $vars['email'] = "%" . $vars['email'] . "%";
            $found_where = true;
        }
        if (!empty($vars['dataInicial'])) {
            $where_params[] = "log_auditoria.data_log >= STR_TO_DATE(CONCAT(:dataInicial:, ' 00:00:00'), '%Y-%m-%d %H:%i:%s')";
            $found_where = true;
        } 
        if (!empty($vars['dataFinal'])) {
            $where_params[] = "log_auditoria.data_log <= STR_TO_DATE(CONCAT(:dataFinal:, ' 23:59:59'), '%Y-%m-%d %H:%i:%s')";
            $found_where = true;
        }
        $sql_where = '';
        if ($found_where)
            $sql_where = "\nWHERE " . implode(' AND ', $where_params);

        # Verifica se existe alguma requisição de ordenação e aplíca na cláusula order by
        $order = $vars['order'];
        unset($vars['order']);
        $sql_orderby = '';
        if (!empty($order)) {
            $sort_col = $order[0]['column'];
            $sort_dir = strtoupper($order[0]['dir']);
            $sort_dir = in_array($sort_dir, ['ASC', 'DESC']) ? $sort_dir : '';
            $sql_orderby = "\nORDER BY " . $cols[$sort_col] . " " . $sort_dir . " ";
        }

        # Ajuste de offset e paginação
        $limit = (int)$vars['length'];
        $offset = (int)$vars['start'];
        $sql_page = "\nLIMIT {$limit} OFFSET {$offset}";

        $sql_count = "SELECT COUNT(*) AS total " . $sql_from . $sql_join . $sql_where; // Máximo de linhas sem a paginação
        $sql_data = $sql_select . $sql_from . $sql_join . $sql_where . $sql_orderby . $sql_page; // Máximo de linhas com os filtros

        # Executa a query
        $query_count = $this->query($sql_count, $vars)->getRowArray()['total'];
        # log_message('info', $this->getLastQuery());
        $results = $this->query($sql_data, $vars)->getResultArray();
        # log_message('info', $this->getLastQuery());

        return [
            $results,
            $query_count
        ];

    }
}
