<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql; // Importe RawSql para CURRENT_TIMESTAMP

class CreateTipoDenunciaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tipo' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'categoria' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'unique' => true, // Nome do tipo de denúncia deve ser único
            ],
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 4000,
                'null' => true, // Descrição pode ser opcional
                'default' => null,
            ],
            'ativo' => [
                'type' => 'INT', // Para 1 ou 0
                'constraint' => 1,
                'null' => false,
                'default' => 1, // Padrão 1 (ativo)
            ],
            'data_criacao' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'data_edicao' => [
                'type' => 'TIMESTAMP',
                'null' => true, // Pode ser null no momento da criação
                'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('id_tipo');
        $this->forge->createTable('tipo_denuncia', true);

        $this->db->table('tipo_denuncia')->insertBatch([
            [
                'categoria' => 'Meio Ambiente',
                'descricao' => 'Denúncias relacionadas a poluição, desmatamento, e outros danos ambientais.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Proteção Animal',
                'descricao' => 'Denúncias de maus-tratos ou abandono de animais.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Iluminação Pública',
                'descricao' => 'Problemas com postes de luz, lâmpadas queimadas ou falta de iluminação.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Trânsito e Vias',
                'descricao' => 'Problemas de tráfego, buracos em vias, sinalização deficiente.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Saneamento Básico',
                'descricao' => 'Vazamentos de água/esgoto, falta de coleta de lixo, problemas com bueiros.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Saúde Pública',
                'descricao' => 'Focos de mosquitos transmissores de doenças, problemas em unidades de saúde, fiscalização sanitária.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Obras e Edificações',
                'descricao' => 'Construções irregulares, obras perigosas, imóveis abandonados com risco.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Poluição Sonora',
                'descricao' => 'Ruído excessivo de estabelecimentos, festas, obras fora de hora.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Zeladoria Urbana / Serviços Públicos',
                'descricao' => 'Manutenção de praças/parques, limpeza de vias, poda de árvores em risco, problemas com transporte público.',
                'ativo' => 1,
            ],
            [
                'categoria' => 'Outros',
                'descricao' => 'Demais problemas não classificados nas opções anteriores.',
                'ativo' => 1,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('tipo_denuncia', true);
    }
}