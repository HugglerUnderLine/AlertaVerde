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

    }

    public function down()
    {
        $this->forge->dropTable('tipo_denuncia', true);
    }
}