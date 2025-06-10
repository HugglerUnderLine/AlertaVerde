<?php

namespace App\Database\Migrations;

use App\Models\DenunciaModel;
use App\Models\OrgaoModel;
use App\Models\OrgaoTipoDenunciaAtuacaoModel;
use App\Models\TipoDenunciaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Database\Migration;

class DeviaUsarSeederMasEIsso extends Migration
{
    public function up()
    {
        $orgaoModel = new OrgaoModel();

        $this->db->table('orgaos')->insert([ // 1
            'nome_orgao' => 'ALERTA VERDE',
            'descricao' => 'ORGAO RESPONSAVEL PELA GESTAO DO PORTAL DE DENUNCIAS ALERTA VERDE - DESENVOLVIMENTO DE PROJETO 2',
            'telefone_contato' => '(42) 4002-8922',
            'email_institucional' => 'contato@alertaverde.com.br',
            'logradouro' => 'RUA CORONEL DULCIDIO',
            'numero' => '253',
            'bairro' => 'Centro',
            'cep' => '84010-280',
            'ponto_referencia' => 'AO LADO DO BUTECO DO SEU ZE',
        ]);

        $this->db->table('orgaos')->insert([ // 2
            'nome_orgao' => 'PREFEITURA MUNICIPAL DE PONTA GROSSA',
            'descricao' => 'ORGAO RESPONSAVEL PELA ADMINISTRACAO DO MUNICIPIO DE PONTA GROSSA - PR',
            'telefone_contato' => '(42) 3030-3030',
            'email_institucional' => 'contato@pmpg.gov.br',
            'logradouro' => 'AV VISCONDE DE TAUNAY',
            'numero' => '950',
            'bairro' => 'Centro',
            'cep' => '84000-000',
            'ponto_referencia' => 'AO LADO DA CAMARA MUNICIPAL',
        ]);

        $this->db->table('orgaos')->insert([ // 3
            'nome_orgao' => 'VLADMIR PUTIN',
            'descricao' => 'RESPONSAVEL POR MUITA COISA QUE NEM VOU FALAR, VAI QUE ELE VEM ATRAS...',
            'telefone_contato' => '(27) 1111-1111',
            'email_institucional' => 'vladmir@putin.com.ru',
            'logradouro' => 'RUA EM MOSCOW',
            'numero' => '1',
            'bairro' => 'SABE DEUS',
            'cep' => '22222-222',
            'ponto_referencia' => 'PERTINHO DA UCRANIA',
        ]);

        $this->db->table('orgaos')->insert([ // 4
            'nome_orgao' => 'ORGAO GENERICO',
            'descricao' => 'RESPONSAVEL POR LIDAR COM ASSUNTOS GENERICOS',
            'telefone_contato' => '(22) 2222-2222',
            'email_institucional' => 'orgao@generico.com.br',
            'logradouro' => 'RUA GENERICA',
            'numero' => '2',
            'bairro' => 'GENERICO DEMAIS',
            'cep' => '33333-333',
            'ponto_referencia' => 'LA MESMO',
        ]);

        $tipoDenuncia = new TipoDenunciaModel();

        $this->db->table('tipo_denuncia')->insertBatch([
            [ // 1
                'categoria' => 'Meio Ambiente',
                'descricao' => 'Denúncias relacionadas a poluição, desmatamento, e outros danos ambientais.',
                'ativo' => 1,
            ],
            [// 2
                'categoria' => 'Proteção Animal',
                'descricao' => 'Denúncias de maus-tratos ou abandono de animais.',
                'ativo' => 1,
            ],
            [// 3
                'categoria' => 'Iluminação Pública',
                'descricao' => 'Problemas com postes de luz, lâmpadas queimadas ou falta de iluminação.',
                'ativo' => 1,
            ],
            [// 4
                'categoria' => 'Trânsito e Vias',
                'descricao' => 'Problemas de tráfego, buracos em vias, sinalização deficiente.',
                'ativo' => 1,
            ],
            [// 5
                'categoria' => 'Saneamento Básico',
                'descricao' => 'Vazamentos de água/esgoto, falta de coleta de lixo, problemas com bueiros.',
                'ativo' => 1,
            ],
            [// 6
                'categoria' => 'Saúde Pública',
                'descricao' => 'Focos de mosquitos transmissores de doenças, problemas em unidades de saúde, fiscalização sanitária.',
                'ativo' => 1,
            ],
            [// 7
                'categoria' => 'Obras e Edificações',
                'descricao' => 'Construções irregulares, obras perigosas, imóveis abandonados com risco.',
                'ativo' => 1,
            ],
            [// 8
                'categoria' => 'Poluição Sonora',
                'descricao' => 'Ruído excessivo de estabelecimentos, festas, obras fora de hora.',
                'ativo' => 1,
            ],
            [// 9
                'categoria' => 'Zeladoria Urbana',
                'descricao' => 'Manutenção de praças/parques, limpeza de vias, poda de árvores em risco, problemas com transporte público.',
                'ativo' => 1,
            ],
            [// 10
                'categoria' => 'Outros',
                'descricao' => 'Demais problemas não classificados nas opções anteriores.',
                'ativo' => 1,
            ],
        ]);

        // Criação de usuário padrão (ADMIN)
        $usuarioModel = new UsuarioModel();

        $this->db->table('usuarios')->insert([ //1
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'ALERTA VERDE',
            'email' => 'contato@alertaverde.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'admin',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '1'
        ]);

        $this->db->table('usuarios')->insert([ //2
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'PREFEITURA MUNICIPAL DE PONTA GROSSA',
            'email' => 'contato@pmpg.gov.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_master',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '2'
        ]);

        $this->db->table('usuarios')->insert([ //3
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'LUIZ RONALDO SANTOS',
            'email' => 'luiz@ronaldo.santos.com',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_representante',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '2'
        ]);

        $this->db->table('usuarios')->insert([ //4
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'PEDRO PEDRO PEDRO PEDRO',
            'email' => 'pedro.pedro@pedro.com',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_representante',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '2'
        ]);

        $this->db->table('usuarios')->insert([ //5
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'VLADMIR PUTIN',
            'email' => 'vladmir@putin.com.ru',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_master',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '3'
        ]);

        $this->db->table('usuarios')->insert([ //6
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'BLYAT PROST SMIRNOFF',
            'email' => 'blyat@askov.com.ru',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_representante',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '3'
        ]);

        $this->db->table('usuarios')->insert([ //7
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'PERDI A CRIATIVIDADE JA',
            'email' => 'perdi@criatividade.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_representante',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '3'
        ]);

        $this->db->table('usuarios')->insert([ //8
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'ORGAO GENERICO',
            'email' => 'orgao@generico.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_master',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '4'
        ]);

        $this->db->table('usuarios')->insert([ //9
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'USUARIO GENERICO DO ORGAO GENERICO',
            'email' => 'usuario1@generico.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'orgao_representante',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => '4'
        ]);

        $this->db->table('usuarios')->insert([ //10
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'CIDADAO GENERICO 1',
            'email' => 'cidadao@generico1.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'cidadao',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => null
        ]);

        $this->db->table('usuarios')->insert([ //11
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'CIDADAO GENERICO 2',
            'email' => 'cidadao@generico2.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'cidadao',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => null
        ]);

        $this->db->table('usuarios')->insert([ //12
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'CIDADAO GENERICO 3',
            'email' => 'cidadao@generico3.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'cidadao',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => null
        ]);

        $this->db->table('usuarios')->insert([ //13
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'CIDADAO GENERICO 4',
            'email' => 'cidadao@generico4.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'cidadao',
            'ativo' => 1, // 1 para ativo
            'id_orgao_fk' => null
        ]);

        $tipoAtuacao = new OrgaoTipoDenunciaAtuacaoModel();
        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 1,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 2,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 3,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 4,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 5,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 6,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 7,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 8,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 9,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 1,
            'id_tipo_fk' => 10,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 2,
            'id_tipo_fk' => 10,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 2,
            'id_tipo_fk' => 9,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 2,
            'id_tipo_fk' => 8,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 2,
            'id_tipo_fk' => 7,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 3,
            'id_tipo_fk' => 1,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 3,
            'id_tipo_fk' => 2,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 3,
            'id_tipo_fk' => 3,
        ]);

        $this->db->table('orgao_tipo_denuncia_atuacao')->insert([
            'id_orgao_fk' => 4,
            'id_tipo_fk' => 4,
        ]);

        $denunciaModel = new DenunciaModel();
        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 11,
            'id_tipo_fk' => 1,
            'titulo_denuncia' => 'ARVORE CAIDA',
            'detalhes' => 'CAIU UMA ARVORE DO LADO AQUI DE CASA.',
            'logradouro' => 'RUA AQUI DE CASA',
            'numero' => 111,
            'bairro' => 'BAIRRO AQUI DE CASA',
            'cep' => '11111-111',
            'ponto_referencia' => 'DO LADO DA MINHA CASA',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 11,
            'id_tipo_fk' => 2,
            'titulo_denuncia' => 'CACHORRO DO VIZINHO CHORA O DIA TODO. TO PREOCUPADO',
            'detalhes' => 'O DOG CHORA DIA E NOITE. ACHO QUE O VIZINHO MALTRATA ELE.',
            'logradouro' => 'RUA DOS BOBOS',
            'numero' => 0,
            'bairro' => 'SAO JOAO',
            'cep' => '22222-222',
            'ponto_referencia' => 'VIZINHO DO MEU VIZINHO',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 12,
            'id_tipo_fk' => 3,
            'titulo_denuncia' => 'POSTE DE ILUMINACAO PUBLICA CAIDO NO MEIO DA RUA',
            'detalhes' => 'APARENTEMENTE, CAIU UM POSTE AQUI, E TA TODO MUNDO ROUBANDO O COBRE!',
            'logradouro' => 'RUA DO COBRE',
            'numero' => 666,
            'bairro' => 'SANTO COBRE',
            'cep' => '33333-333',
            'ponto_referencia' => 'EM FRENTE A LOJA DE CABO DE COBRE 2.5MM',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 12,
            'id_tipo_fk' => 4,
            'titulo_denuncia' => 'AQUI VAI COMECAR A FICAR GENERICO',
            'detalhes' => 'DETALHE GENERICO DA DENUNCIA BASE 1',
            'logradouro' => 'RUA GENERICA',
            'numero' => 333,
            'bairro' => 'BAIRRO QUALQUER',
            'cep' => '44444-444',
            'ponto_referencia' => 'AO LADO DO POSTO DE GASOLINA 1',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 12,
            'id_tipo_fk' => 5,
            'titulo_denuncia' => 'LOREM IPSUM DOLORES AMET',
            'detalhes' => 'LOREM IPSUM LOREM IPSUM LOREM IPSUM',
            'logradouro' => 'LOREM IPSUM AT FET LOS DOLE',
            'numero' => 444,
            'bairro' => 'PARO AI IRMAO',
            'cep' => '55555-555',
            'ponto_referencia' => 'AO LADO DO POSTO DE GASOLINA 2',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 12,
            'id_tipo_fk' => 6,
            'titulo_denuncia' => 'LOREM LOREM IPSUM IPSUM',
            'detalhes' => 'DOLORES DOLORES DOLORES DOLORES',
            'logradouro' => 'RUA RUAS RUAS',
            'numero' => 555,
            'bairro' => 'IPLOREM SUM',
            'cep' => '66666-666',
            'ponto_referencia' => 'AO LADO DO POSTO DE GASOLINA 3',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 13,
            'id_tipo_fk' => 7,
            'titulo_denuncia' => 'LOREM LOREM IPSUM IPSUM',
            'detalhes' => 'DOLORES DOLORES DOLORES DOLORES',
            'logradouro' => 'RUA RUAS RUAS',
            'numero' => 777,
            'bairro' => 'IPLOREM SUM',
            'cep' => '77777-777',
            'ponto_referencia' => 'AO LADO DO POSTO DE GASOLINA 3',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 13,
            'id_tipo_fk' => 8,
            'titulo_denuncia' => 'LOREM LOREM IPSUM IPSUM',
            'detalhes' => 'DOLORES DOLORES DOLORES DOLORES',
            'logradouro' => 'RUA RUAS RUAS',
            'numero' => 888,
            'bairro' => 'IPLOREM SUM',
            'cep' => '88888-888',
            'ponto_referencia' => 'AO LADO DO POSTO DE GASOLINA 3',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 13,
            'id_tipo_fk' => 9,
            'titulo_denuncia' => 'TITULO DENUNCIA',
            'detalhes' => 'DETALHES DA DENUNCIA',
            'logradouro' => 'LOGRADOURO DA DENUNCIA',
            'numero' => 999,
            'bairro' => 'BAIRRO DA DENUNCIA',
            'cep' => '99999-999',
            'ponto_referencia' => 'AO LADO DO POSTO DE GASOLINA 237',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);

        $this->db->table('denuncias')->insert([
            'id_usuario_fk' => 13,
            'id_tipo_fk' => 10,
            'titulo_denuncia' => 'TITULO DA DENUNCIA PRA CATEGORIA OUTROS',
            'detalhes' => 'DETALHES DA DENUNCIA PRA CATEGORIA OUTROS',
            'logradouro' => 'LOGRADOURO DA DENUNCIA PRA CATEGORIA OUTROS',
            'numero' => 10000,
            'bairro' => 'BAIRRO DA DENUNCIA PRA CATEGORIA OUTROS',
            'cep' => '10101-010',
            'ponto_referencia' => 'AO LADO DO OUTRO POSTO DE GASOLINA',
            'status_denuncia' => 'Pendente',
            'id_orgao_responsavel_fk' => null,
            'id_usuario_responsavel_fk' => null,
        ]);
    }

    public function down()
    {
        //
    }
}
