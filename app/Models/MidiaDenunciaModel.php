<?php

namespace App\Models;

use CodeIgniter\Model;

class MidiaDenunciaModel extends Model
{
    protected $table            = 'midia_denuncia';
    protected $primaryKey       = 'id_midia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_denuncia_fk', 'tipo_midia', 'caminho_arquivo', 'data_submissao'];

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

    public function getMidiasByDenuncias(array $idsDenuncias): array {
        if (empty($idsDenuncias)) {
            return [];
        }

        $builder = $this->builder();
        $builder->select('id_denuncia_fk, tipo_midia, caminho_arquivo');
        $builder->whereIn('id_denuncia_fk', $idsDenuncias);

        $result = $builder->get()->getResultArray();

        $agrupadas = [];
        foreach ($result as $midia) {
            $agrupadas[$midia['id_denuncia_fk']][] = [
                'tipo_midia' => $midia['tipo_midia'],
                'caminho_arquivo' => $midia['caminho_arquivo']
            ];
        }

        return $agrupadas;
    }

    public function inserirMidia($data) {
        $regID = $this->insert($data);
        # Se a inserção for bem-sucedida
        if(!empty($regID)) {
            return $regID;
        }
        # Caso contrário, retorna false.
        return false;
    }
    
}
