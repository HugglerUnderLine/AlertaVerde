<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql; // Importe RawSql, caso use CURRENT_TIMESTAMP

class CreateOrgaoTipoDenunciaAtuacaoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_orgao_tipo_atuacao' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_orgao_fk' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'id_tipo_fk' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_orgao_tipo_atuacao');

        // Adiciona chaves estrangeiras
        // Depende de 'orgaos'
        $this->forge->addForeignKey('id_orgao_fk', 'orgaos', 'id_orgao', 'CASCADE', 'CASCADE');
        // ON UPDATE CASCADE: Se o id_orgao na tabela 'orgaos' mudar, reflete aqui.
        // ON DELETE CASCADE: Se um órgão for deletado, suas atuações também serão.

        // Depende de 'tipo_denuncia'
        $this->forge->addForeignKey('id_tipo_fk', 'tipo_denuncia', 'id_tipo', 'CASCADE', 'CASCADE');
        // ON UPDATE CASCADE: Se o id_tipo na tabela 'tipo_denuncia' mudar, reflete aqui.
        // ON DELETE CASCADE: Se um tipo de denúncia for deletado, as atuações relacionadas a ele também serão.

        // Adicionar índice único para garantir que um órgão não tenha o mesmo tipo de denúncia mais de uma vez
        $this->forge->addUniqueKey(['id_orgao_fk', 'id_tipo_fk']);

        $this->forge->createTable('orgao_tipo_denuncia_atuacao', true);
    }

    public function down()
    {
        $this->forge->dropTable('orgao_tipo_denuncia_atuacao', true);
    }
}