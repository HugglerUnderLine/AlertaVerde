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

    public function getEstatisticasDenunciasOrgao(int $idOrgao): array {
        # Definição dos períodos
        $hoje = date('Y-m-d');

        # Mês Atual
        $inicioMesAtual = date('Y-m-01', strtotime($hoje));
        $fimMesAtual = date('Y-m-t', strtotime($hoje));

        # Mês Anterior
        $inicioMesAnterior = date('Y-m-01', strtotime($inicioMesAtual . ' -1 month'));
        $fimMesAnterior = date('Y-m-t', strtotime($inicioMesAtual . ' -1 month'));

        # Query para buscar contagens por status e totais para os dois períodos
        $sql = "
            SELECT status_denuncia,
                   COUNT(CASE 
                        WHEN data_submissao BETWEEN :inicioMesAtual: AND :fimMesAtual: THEN id_denuncia 
                        ELSE NULL 
                   END) AS contagem_atual,
                   COUNT(CASE 
                        WHEN data_submissao BETWEEN :inicioMesAnterior: AND :fimMesAnterior: THEN id_denuncia 
                        ELSE NULL 
                   END) AS contagem_anterior
            FROM denuncias
            WHERE id_orgao_responsavel_fk = :idOrgao:
            AND data_submissao >= :dataCorteInicio:
            GROUP BY status_denuncia

            UNION ALL

            SELECT 
                'TOTAL_GERAL' as status_denuncia, -- <<< CORREÇÃO AQUI
                COUNT(CASE 
                        WHEN data_submissao BETWEEN :inicioMesAtual: AND :fimMesAtual: THEN id_denuncia 
                        ELSE NULL 
                    END) AS contagem_atual,
                COUNT(CASE 
                        WHEN data_submissao BETWEEN :inicioMesAnterior: AND :fimMesAnterior: THEN id_denuncia 
                        ELSE NULL 
                    END) AS contagem_anterior
            FROM denuncias
            WHERE id_orgao_responsavel_fk = :idOrgao:
            AND data_submissao >= :dataCorteInicio:
        ";

        # Parâmetros para a query
        $params = [
            'idOrgao'           => $idOrgao,
            'inicioMesAtual'    => $inicioMesAtual . ' 00:00:00',
            'fimMesAtual'       => $fimMesAtual . ' 23:59:59',
            'inicioMesAnterior' => $inicioMesAnterior . ' 00:00:00',
            'fimMesAnterior'    => $fimMesAnterior . ' 23:59:59',
            'dataCorteInicio'   => $inicioMesAnterior . ' 00:00:00'
        ];

        $queryResult = $this->db->query($sql, $params)->getResultArray();

        # Estrutura para o resultado final
        $estatisticas = [
            'total'        => ['atual' => 0, 'anterior' => 0, 'variacao_percentual' => 0, 'texto_variacao' => ''],
            'pendente'     => ['atual' => 0, 'anterior' => 0, 'variacao_percentual' => 0, 'texto_variacao' => ''],
            'em_progresso' => ['atual' => 0, 'anterior' => 0, 'variacao_percentual' => 0, 'texto_variacao' => ''],
            'resolvido'    => ['atual' => 0, 'anterior' => 0, 'variacao_percentual' => 0, 'texto_variacao' => '']
        ];

        # Mapeamento dos status para as chaves do array $estatisticas
        $mapStatusParaChave = [
            'Pendente'     => 'pendente',
            'Em Progresso' => 'em_progresso',
            'Resolvido'    => 'resolvido',
            'TOTAL_GERAL'  => 'total'
        ];

        foreach ($queryResult as $row) {
            $statusBanco = $row['status_denuncia'];
            if (isset($mapStatusParaChave[$statusBanco])) {
                $chave = $mapStatusParaChave[$statusBanco];
                $estatisticas[$chave]['atual']    = (int) $row['contagem_atual'];
                $estatisticas[$chave]['anterior'] = (int) $row['contagem_anterior'];
            }
        }

        # Cálculo da variação percentual
        foreach ($estatisticas as $key => &$stat) {
            $atual = $stat['atual'];
            $anterior = $stat['anterior'];

            if ($anterior > 0) {
                $variacao = (($atual - $anterior) / $anterior) * 100;
                $stat['variacao_percentual'] = round($variacao, 2);
                $stat['texto_variacao'] = "📍 " . ($variacao >= 0 ? '+' : '') . round($variacao) . '% em relação ao mês passado.';
            } elseif ($atual > 0 && $anterior === 0) {
                $stat['variacao_percentual'] = 100;
                $stat['texto_variacao'] = 'Novas denúncias este mês.';
            } else {
                $stat['variacao_percentual'] = 0;
                $stat['texto_variacao'] = 'Sem variação ou dados anteriores.';
            }
        }
        unset($stat);

        return $estatisticas;
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
                              TO_CHAR(denuncias.data_submissao, \'DD/MM/YYYY HH24:MI\') as "dataDenuncia",
                              TO_CHAR(denuncias.data_atribuicao, \'DD/MM/YYYY HH24:MI\') as "dataAtribuicao",
                              TO_CHAR(denuncias.data_conclusao, \'DD/MM/YYYY HH24:MI\') as "dataConclusao"
                       FROM denuncias';

        $sql_join = "\nJOIN usuarios ON denuncias.id_usuario_fk = usuarios.id_usuario
                       JOIN tipo_denuncia ON denuncias.id_tipo_fk = tipo_denuncia.id_tipo
                       JOIN orgaos ON denuncias.id_orgao_responsavel_fk = orgaos.id_orgao";


        # Verifica se existe algum filtro aplicado do titulo da denuncia e aplica na cláusula WHERE
        $found_where = false;
        $where_params = array();
        if (!empty($vars['titulo'])) {
            $where_params[] = "UPPER(denuncias.titulo_denuncia) LIKE :titulo:";
            $vars['titulo'] = "%" . $vars['titulo'] . "%";
            $found_where = true;
        }
        if (!empty($vars['id_orgao'])) {
            $where_params[] = "denuncias.id_orgao_responsavel_fk = :id_orgao:";
            $found_where = true;
        }
        if (!empty($vars['categoria'])) {
            $where_params[] = "unaccent(UPPER(tipo_denuncia.categoria)) LIKE :categoria:";
            $vars['categoria'] = "%" . $vars['categoria'] . "%";
            $found_where = true;
        }
        if (!empty($vars['status'])) {
            $where_params[] = "UPPER(denuncias.status_denuncia) = :status:";
            $found_where = true;
        }
        $sql_where = '';
        if ($found_where) {
            $sql_where .= "\nWHERE " . implode("\nAND ", $where_params);
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

        $sql_count = "SELECT COUNT(*) AS total FROM denuncias " . $sql_join . $sql_where; // Total de linhas sem a paginação
        $sql_data = $sql_select. $sql_join . $sql_where  . $sql_orderBy . $sql_page; // Conteúdo da tabela

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

    public function getDenunciasDoUsuario(array $filtros): array {
        $builder = $this->db->table('denuncias');
        $builder->select("
            denuncias.id_denuncia AS id_denuncia,
            denuncias.titulo_denuncia AS titulo,
            denuncias.detalhes AS descricao,
            denuncias.status_denuncia AS status,
            denuncias.logradouro || ', ' || denuncias.numero || ' - ' || denuncias.bairro AS localizacao,
            denuncias.data_submissao AS data,
            orgaos.nome_orgao AS orgao_responsavel
        ");

        $builder->join('tipo_denuncia', 'denuncias.id_tipo_fk = tipo_denuncia.id_tipo');
        $builder->join('usuarios', 'denuncias.id_usuario_fk = usuarios.id_usuario');
        $builder->join('orgaos', 'denuncias.id_orgao_responsavel_fk = orgaos.id_orgao', 'left');

        # Filtro obrigatório: ID do usuário
        if (!empty($filtros['id_usuario'])) {
            $builder->where('denuncias.id_usuario_fk', $filtros['id_usuario']);
        }

        # Filtro de título
        if (!empty($filtros['titulo'])) {
            $builder->like('UPPER(denuncias.titulo_denuncia)', strtoupper($filtros['titulo']));
        }

        # Filtro de status (apenas se não for "Todas")
        if (!empty($filtros['status']) && strtolower($filtros['status']) !== 'todas') {
            $builder->where('denuncias.status_denuncia', $filtros['status']);
        }

        $builder->orderBy('denuncias.data_submissao', 'DESC');

        $dados = $builder->get()->getResultArray();
        // log_message('info', $this->getLastQuery());
        return $dados;
    }


    public function getDetalhesDenuncia($idDenuncia): array {
        $builder = $this->db->table('denuncias');
        $builder->select("
            titulo_denuncia,
            id_tipo_fk,
            detalhes,
            status_denuncia,
            logradouro,
            numero,
            bairro,
            cep,
            ponto_referencia
        ")->where('id_denuncia', $idDenuncia);

        $dados = $builder->get()->getResultArray();
        // log_message('info', $this->getLastQuery());
        return $dados;
    }


    public function getDenunciasDoOrgao(int $orgaoID): array {

        $sql_select = 'SELECT denuncias.id_denuncia,
                              denuncias.id_tipo_fk,
                              denuncias.titulo_denuncia,
                              denuncias.detalhes,
                              denuncias.status_denuncia,
                              denuncias.logradouro,
                              denuncias.numero,
                              denuncias.bairro,
                              denuncias.cep,
                              denuncias.ponto_referencia,
                              denuncias.data_submissao,
                              tipo_denuncia.categoria
                       FROM denuncias';

        $sql_join = "\nJOIN tipo_denuncia ON denuncias.id_tipo_fk = tipo_denuncia.id_tipo";

        $sql_where = "\nWHERE id_orgao_responsavel_fk IS NULL 
                        AND status_denuncia = 'Pendente'
                        AND denuncias.id_tipo_fk IN (
                            SELECT id_tipo_fk 
                            FROM orgao_tipo_denuncia_atuacao
                            WHERE id_orgao_fk = :orgaoID:
                        )";

        $sql_orderBy = "\nORDER BY data_submissao ASC";

        $sql_data = $sql_select. $sql_join . $sql_where  . $sql_orderBy; // Conteúdo da query

        # Executa a query
        $results = $this->query($sql_data, ['orgaoID' => $orgaoID])->getResultArray();

        // log_message('info', $this->getLastQuery());

        // log_message('info', json_encode($results, JSON_PRETTY_PRINT));

        return $results;
    }

    # Método genérico para operações de Update / Insert
    public function denunciaUpsert($data, $id = null) {
        try {
            $builder = $this->db->table($this->table);

            if (!empty($id)) {
                # Atualiza se o ID foi passado como parâmetro
                $builder->where('id_denuncia', $id);
                $success = $builder->update($data);

                return $success ? $id : false;
            }

            # Insere um novo registro se o ID não foi fornecido
            $success = $builder->insert($data);

            if ($success) {
                $insertID = $this->db->insertID();

                # Verificação extra de segurança
                if (!empty($insertID) && is_numeric($insertID)) {
                    return $insertID;
                }

                log_message('error', '[NOVA DENUNCIA] ID inválido após insert. Valor: ' . print_r($insertID, true));
                return false;
            }

            return false;
        } catch (\Exception $e) {
            log_message('critical', 'Upsert error: ' . $e->getMessage());
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
