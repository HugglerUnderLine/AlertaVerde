<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoDenunciaModel extends Model
{
    protected $table            = 'tipo_denuncia';
    protected $primaryKey       = 'id_tipo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome', 'descricao', 'ativo', 'data_criacao', 'data_edicao'];

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

    public function getTiposDenuncia() {
        # Busca um usuário pelo e-mail

        $sql_query = "SELECT tipo_denuncia.id_tipo,
                             tipo_denuncia.categoria,
                             tipo_denuncia.descricao
                      FROM tipo_denuncia
                      ORDER BY id_tipo ASC";

        $data = $this->query($sql_query)->getResultArray();

        // log_message('info', json_encode($data, JSON_PRETTY_PRINT));

        return $data;
    }

}
