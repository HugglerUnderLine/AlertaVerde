<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateMidiaDenunciaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_midia' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_denuncia_fk' => [ // Chave estrangeira para a denúncia a que esta mídia pertence
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'tipo_midia' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'caminho_arquivo' => [ // URL ou caminho para o arquivo armazenado
                'type' => 'VARCHAR',
                'constraint' => 4000,
                'null' => false,
            ],
            'data_submissao' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id_midia');

        // Depende de 'denuncias'
        $this->forge->addForeignKey('id_denuncia_fk', 'denuncias', 'id_denuncia', 'CASCADE', 'CASCADE');
        // ON UPDATE CASCADE: Se o id_denuncia na tabela 'denuncias' mudar, reflete aqui.
        // ON DELETE CASCADE: Se uma denúncia for deletada, todas as mídias associadas a ela também serão.

        $this->forge->createTable('midia_denuncia', true);
    }

    public function down()
    {
        $this->forge->dropTable('midia_denuncia', true);
    }
}