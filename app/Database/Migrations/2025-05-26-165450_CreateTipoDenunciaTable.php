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
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'unique' => true, // Nome do tipo de denúncia deve ser único
            ],
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 4000,
                'null' => true, // Descrição pode ser opcional
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
                'default' => new RawSql('CURRENT_TIMESTAMP'), // Padrão para a hora atual (será atualizado por trigger)
            ],
        ]);

        $this->forge->addPrimaryKey('id_tipo');
        $this->forge->createTable('tipo_denuncia', true); // Nome da tabela em minúsculas e plural

        // Opcional: Inserir alguns tipos de denúncia padrão para começar
        $this->db->table('tipo_denuncia')->insertBatch([
            [
                'nome' => 'Meio Ambiente',
                'descricao' => 'Denúncias relacionadas a poluição, desmatamento, e outros danos ambientais.',
                'ativo' => 1,
            ],
            [
                'nome' => 'Proteção Animal',
                'descricao' => 'Denúncias de maus-tratos ou abandono de animais.',
                'ativo' => 1,
            ],
            [
                'nome' => 'Iluminação Pública',
                'descricao' => 'Problemas com postes de luz, lâmpadas queimadas ou falta de iluminação.',
                'ativo' => 1,
            ],
            [
                'nome' => 'Trânsito e Vias',
                'descricao' => 'Problemas de tráfego, buracos em vias, sinalização deficiente.',
                'ativo' => 1,
            ],
            // Adicione mais tipos conforme necessário
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('tipo_denuncia', true);
    }
}