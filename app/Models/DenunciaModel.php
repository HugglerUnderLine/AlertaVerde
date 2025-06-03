<?php

namespace App\Models;

use CodeIgniter\Model;

class DenunciaModel extends Model
{
    protected $table            = 'denuncias';
    protected $primaryKey       = 'id_denuncia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_usuario_fk', 'id_tipo_fk', 'detalhes', 'logradouro', 'numero', 'bairro', 'cep', 'ponto_referencia', 'latitude', 'longitude', 'status_denuncia', 'id_orgao_responsavel_fk', 'id_usuario_responsavel_fk', 'data_submissao', 'data_atribuicao', 'data_conclusao', 'titulo_denuncia'];

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

    public function countDenuncias() {
        return $this->db->table('denuncias')->countAll();
    }
 
    public function simpleGetDenuncias() {
        $sql_query = "SELECT denuncias.id_denuncia,
                             denuncias.id_usuario_fk,
                             denuncias.id_tipo_fk,
                             denuncias.detalhes,
                             denuncias.logradouro,
                             denuncias.numero,
                             denuncias.bairro,
                             denuncias.cep,
                             denuncias.ponto_referencia,
                             denuncias.status_denuncia,
                             denuncias.id_orgao_responsavel_fk,
                             denuncias.data_submissao,
                             denuncias.data_atribuicao,
                             denuncias.data_conclusao,
                             denuncias.titulo_denuncia
                      FROM denuncias";

        return $this->query($sql_query)->getResultArray();
    }

    public function complexGetDenuncias($vars, $cols) {

        $sql_select = 'SELECT denuncias.titulo_denuncia as "tituloDenuncia",
                              tipo_denuncia.categoria,
                              denuncias.status_denuncia as "status",
                              usuarios.nome_completo as "nomeDenunciante",
                              denuncias.id_denuncia as "denunciaID",
                              denuncias.id_usuario_fk as "usuarioID",
                              denuncias.id_tipo_fk as "tipoDenunciaID",
                              denuncias.detalhes,
                              denuncias.logradouro,
                              denuncias.numero,
                              denuncias.bairro,
                              denuncias.cep as "CEP",
                              denuncias.ponto_referencia as "pontoReferencia",
                              denuncias.id_orgao_responsavel_fk as "orgaoResponsavelID",
                              orgaos.nome_orgao as "orgaoResponsavel",
                              denuncias.data_submissao as "dataDenuncia",
                              denuncias.data_atribuicao as "dataAtribuicao",
                              denuncias.data_conclusao as "dataConclusao"
                       FROM denuncias';

        $sql_join = "\nJOIN usuarios ON denuncias.id_usuario_fk = usuarios.id_usuario
                     \nJOIN tipo_denuncia ON denuncias.id_tipo_fk = tipo_denuncia.id_tipo
                     \nJOIN orgaos ON denuncias.id_orgao_responsavel_fk = orgaos.id_orgao";


        # Verifica se existe algum filtro aplicado do titulo da denuncia e aplica na cláusula WHERE
        $found_where = false;
        $where_params = array();
        if (!empty($vars['titulo'])) {
            $where_params[] = "UPPER(denuncias.titulo_denuncia) LIKE :titulo:";
            $vars['titulo'] = "%" . $vars['titulo'] . "%";
            $found_where = true;
        }
        $sql_where = '';
        if ($found_where) {
            $sql_where .= implode("\nAND ", $where_params);
        }

        # Verifica se foi aplicado alguma ordenação para construir o Order By
        $order = $vars['order'];
        unset($vars['order']);
        $sql_orderBy = '';
        if (!empty($order)) {
            $sort_col = $order[0]['column'];
            $sort_dir = strtoupper($order[0]['dir']);
            $sort_dir = in_array($sort_dir, ['ASC', 'DESC']) ? $sort_dir : '';
            $sql_orderBy = "\nORDER BY " . $cols[$sort_col] . " " . $sort_dir . " ";
        }

        # Ajustes de Paginação
        $limit = (int)$vars['length'];
        $offset = (int)$vars['start'];
        $sql_page = "\nLIMIT {$limit} OFFSET {$offset}";

        $sql_count = "SELECT COUNT(*) AS total FROM denuncias " . $sql_where . " " . $sql_join; // Total de linhas sem a paginação
        $sql_data = $sql_select . $sql_where . $sql_join . $sql_orderBy . $sql_page; // Conteúdo da tabela

        # Executa a query
        $query_count = $this->query($sql_count, $vars)->getRowArray()['total'];
        $results = $this->query($sql_data, $vars)->getResultArray();

        // log_message('info', $this->getLastQuery());

        // log_message('info', json_encode($results, JSON_PRETTY_PRINT));

        return [
            $results,
            $query_count
        ];

    }

    # Método genérico para operações de Update / Insert
    public function denunciaUpsert($data, $id = null) {
        try {
            $builder = $this->db->table($this->table);

            if (!empty($id)) {
                # Se a chave primaria esta definida e não é vazia, atualiza
                $builder->where('id_denuncia', $id);
                $builder->update($data);
                if($this->db->transStatus() === false) {
                    return false;
                } else {
                    return true;
                }
            }

            # Do contrário, executa uma inserção
            return $builder->insert($data);
        } catch (\Exception $e) {
            // log_message('critical', 'Upsert error: ' . $e->getMessage());
            return false;
        }
    }


    public function inserirDenuncia($data) {
        return $this->denunciaUpsert($data);
    }


    public function atualizarDenuncia($id, $data) {
        return $this->denunciaUpsert($data, $id);
    }
}
