<?php

namespace App\Models;

use CodeIgniter\Model;

class OrgaoModel extends Model
{
    protected $table            = 'orgaos';
    protected $primaryKey       = 'id_orgao';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome_orgao', 'descricao', 'telefone_contato', 'email_institucional', 'logradouro', 'numero', 'bairro', 'cep', 'ponto_referencia', 'data_criacao', 'data_edicao'];

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

    public function findOrgaoByEmail($email) {
        # Busca um orgão pelo e-mail
        $sql_query = "SELECT orgaos.id_orgao,
                             orgaos.nome_orgao,
                             orgaos.descricao,
                             orgaos.telefone_contato,
                             orgaos.email_institucional,
                             orgaos.logradouro,
                             orgaos.numero,
                             orgaos.bairro,
                             orgaos.cep,
                             orgaos.ponto_referencia
                      FROM orgaos
                      WHERE email_institucional = :email:";

        return $this->query($sql_query, ['email' => $email])->getResultArray();

    }

    public function findOrgaoByID($id) {
        # Busca um orgão pelo ID
        $sql_query = "SELECT orgaos.nome_orgao,
                             orgaos.descricao,
                             orgaos.telefone_contato,
                             orgaos.email_institucional,
                             orgaos.logradouro,
                             orgaos.numero,
                             orgaos.bairro,
                             orgaos.cep,
                             orgaos.ponto_referencia
                      FROM orgaos
                      WHERE id_orgao = :id:";

        return $this->query($sql_query, ['id' => $id])->getResultArray()[0];
    }

    public function complexGetOrgaos($vars, $cols) { // Tratamento dos dados vindos do DataTables para a tabela de usuários

        $sql_select = "SELECT usuarios.id_usuario,
                              usuarios.UUID,
                              usuarios.EMAIL,
                              usuarios.NOME,
                              usuarios.SENHA,
                              usuarios.PERMISSAO";
                        
        $sql_from = "\nFROM usuarios";

        # Verifica se existem filtros presentes referentes ao nome ou e-mail do usuário:
        $found_where = false;
        $where_params = array();
        if(!empty($vars['nome'])) {
            $where_params[] = "usuarios.nome LIKE :nome:";
            $vars['nome'] = "%" . $vars['nome'] . "%";
            $found_where = true;
        }
        if(!empty($vars['email'])) {
            $where_params[] = "usuarios.email LIKE :email:";
            $vars['email'] = "%" . $vars['email'] . "%";
            $found_where = true;
        }
        
        $sql_where = "";
        if ($found_where)
            $sql_where = "\nWHERE " . implode(' AND ', $where_params);

        # Verifica se existe alguma ordenação especificada na tabela e constrói a cláusula ORDER BY:
        $order = $vars['order'];
        unset($vars['order']);
        $sql_orderBy = "";
        if(!empty($order)) {
            $sort_col = $order[0]['column'];
            $sort_dir = strtoupper($order[0]['dir']);
            $sort_dir = in_array($sort_dir, ['ASC', 'DESC']) ? $sort_dir : '';
            $sql_orderBy = "\nORDER BY " . $cols[$sort_col] . " " . $sort_dir . " ";
        }

        # Ajustes de limit e offset para a paginação:
        $limit = (int)$vars['length'];
        $offset = (int)$vars['start'];
        $sql_page = "\nLIMIT {$limit} OFFSET {$offset}";

        $sql_count = "SELECT COUNT(*) AS total " . $sql_from . $sql_where; // Máximo de linhas sem a paginação
        $sql_data = $sql_select . $sql_from . $sql_where . $sql_orderBy . $sql_page; // Tuplas retornadas

        # Execução das queries:
        $query_count = $this->query($sql_count, $vars)->getRowArray()['total'];
        $results = $this->query($sql_data, $vars)-> getResultArray();

        return [
            $results,
            $query_count
        ];
 
    }



    public function inserirOrgao($data) {

        $orgaoID = $this->insert($data);
        # Se a inserção for bem-sucedida
        if(!empty($orgaoID))
            return $orgaoID;

        # Caso contrário, retorna false.
        return false;
    }

    public function editarOrgao($id, $data) {
        # Se o update for bem-sucedido
        if($this->update($id, $data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

}
