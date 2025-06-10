<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_uuid', 'nome_completo', 'email', 'senha', 'tipo_usuario', 'id_orgao_fk', 'ativo', 'data_criacao', 'data_edicao'];

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

    public function generateUUID() {
        $uuid = Uuid::uuid4()->toString(); // Gera um UUID único e aleatório para cada usuário criado

        $sql = "SELECT COUNT(user_uuid) AS total FROM usuarios WHERE user_uuid = :uuid:"; // Verifica se o UUID já existe
        $validUUID = $this->query($sql, ['uuid' => $uuid])->getResultArray()[0]['total'];

        while(!empty($validUUID)) { // Enquanto o UUID gerado for inválido, tenta gerar novamente
            $uuid = Uuid::uuid4()->toString();
            $validUUID = $this->query($sql, ['uuid' => $uuid])->getResultArray()[0]['total'];
        }

        return $uuid;
    }

    public function passwordGenerator() {
        /* 
            Esse método gera uma senha de primeiro acesso aleatória.
            A senha será usada para o primeiro login do usuário, e deve ser alterada no primeiro acesso.
        */

        $upperChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerChars = strtolower($upperChars);
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        # Une todos os caracteres em uma string única.
        $allChars = $upperChars . $lowerChars . $numbers . $specialChars;

        # Certifica-se de que a senha tenha ao menos um de cada tipo de caractere.
        $password = [
            $upperChars[random_int(0, strlen($upperChars) - 1)],
            $lowerChars[random_int(0, strlen($lowerChars) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specialChars[random_int(0, strlen($specialChars) - 1)],
        ];

        # Preenche o restante da senha com caracteres aleatórios.
        # O tamanho maximo da senha gerada sera de 12 caracteres.
        for ($i = 4; $i < 12; $i++) {
            $password[] = $allChars[random_int(0, strlen($allChars) - 1)];
        }

        # Embaralha os caracteres da senha.
        shuffle($password);

        return implode('', $password);

    }

    public function findUserByEmail($email) {
        # Busca um usuário pelo e-mail

        $sql_query = "SELECT usuarios.id_usuario,
                             usuarios.user_uuid,
                             usuarios.email,
                             usuarios.nome_completo,
                             usuarios.senha,
                             usuarios.id_orgao_fk,
                             usuarios.ativo,
                             usuarios.tipo_usuario -- cidadao, orgao_master, orgao_representante, admin
                      FROM usuarios
                      WHERE email = :email:";

        return $this->query($sql_query, ['email' => $email])->getResultArray();

    }

    public function findUserByID($id) {
        # Busca um usuário pelo ID
        $sql_query = "SELECT usuarios.id_usuario,
                             usuarios.user_uuid,
                             usuarios.email,
                             usuarios.nome_completo,
                             usuarios.senha,
                             usuarios.id_orgao_fk,
                             usuarios.tipo_usuario -- cidadao, orgao_master, orgao_representante, admin
                      FROM usuarios
                      WHERE id_usuario = :id:";

        return $this->query($sql_query, ['id' => $id])->getResultArray()[0];
    }

    public function findUserByUUID($uuid) {
        # Busca um usuário pelo UUID

        $sql_query = "SELECT usuarios.nome,
                             usuarios.sobrenome,
                             usuarios.email,
                             usuarios.tipo_usuario
                      FROM usuarios
                      WHERE user_uuid = :uuid:";

        return $this->query($sql_query, ['uuid' => $uuid])->getResultArray()[0];

    }

    public function verificaSenha($password) {
        # Verifica se a senha atual do usuário é válida

        $sql_query = "SELECT usuarios.senha
                      FROM usuarios
                      WHERE usuarios.user_uuid = :uuid:";

        $currPassword = $this->query($sql_query, ['uuid' => session()->get('uuid')])->getResultArray()[0]['senha'];

        return password_verify($password, $currPassword);

    }

    public function complexGetUsuarios($vars, $cols) { // Tratamento dos dados vindos do DataTables para a tabela de usuários

        $sql_select = 'SELECT usuarios.id_usuario as "usuarioID",
                              usuarios.user_uuid as "uuid",
                              usuarios.nome_completo as "nomeUsuario",
                              usuarios.email,
                              usuarios.tipo_usuario as "permissao",
                              usuarios.ativo as "usuarioAtivo",
                              TO_CHAR(usuarios.data_criacao, \'DD/MM/YYYY HH24:MI\') as "criadoEm"';
                        
        $sql_from = "\nFROM usuarios";

        # Verifica se existem filtros presentes referentes ao nome ou e-mail do usuário:
        $found_where = false;
        $where_params = array();
        if(!empty($vars['nome'])) {
            $where_params[] = "usuarios.nome_completo LIKE :nome:";
            $vars['nome'] = "%" . $vars['nome'] . "%";
            $found_where = true;
        }
        if(!empty($vars['email'])) {
            $where_params[] = "usuarios.email LIKE :email:";
            $vars['email'] = "%" . $vars['email'] . "%";
            $found_where = true;
        }
        if(!empty($vars['ativo']) || $vars['ativo'] === 0) {
            $where_params[] = "usuarios.ativo = :ativo:";
            $vars['ativo'] = intval($vars['ativo']);
            $found_where = true;
        }
        if(!empty($vars['id_orgao'])) {
            $where_params[] = "usuarios.id_orgao_fk = :id_orgao:";
            $found_where = true;
        }
        
        $sql_where = "";
        
        if ($found_where) {
            $sql_where = "\nWHERE " . implode(' AND ', $where_params);
        }

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

        // log_message('info', $this->getLastQuery());
        // log_message('info', json_encode($vars, JSON_PRETTY_PRINT));

        return [
            $results,
            $query_count
        ];
 
    }

    public function inserirUsuario($data) {
        # Se a inserção for bem-sucedida
        if($this->insert($data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

    public function editarUsuario($id, $data) {
        # Se o update for bem-sucedido
        if($this->update($id, $data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

    public function changePassword($id, $senha) {
        # Altera a senha do usuário

        $sql_query = "UPDATE usuarios
                      SET senha = :senha:
                      WHERE usuarios.id_usuario = :id:";

        if($this->query($sql_query, ['senha' => password_hash($senha, PASSWORD_DEFAULT), 'id' => $id]))
            return true;

        return false;
    }

}
