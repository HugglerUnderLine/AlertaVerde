<?php

namespace App\Models;

use CodeIgniter\Model;

class OrgaoTipoDenunciaAtuacaoModel extends Model
{
    protected $table            = 'orgao_tipo_denuncia_atuacao';
    protected $primaryKey       = 'id_orgao_tipo_atuacao';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_orgao_fk', 'id_tipo_fk'];

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

    public function getTiposAtuacao($orgaoID) {
        # Recupera as competências do órgao com base no ID
        $sql_query = "SELECT orgao_tipo_denuncia_atuacao.id_tipo_fk
                      FROM orgao_tipo_denuncia_atuacao
                      WHERE id_orgao_fk = :orgaoID:";

        return $this->query($sql_query, ['orgaoID' => $orgaoID])->getResultArray();
    }
}
