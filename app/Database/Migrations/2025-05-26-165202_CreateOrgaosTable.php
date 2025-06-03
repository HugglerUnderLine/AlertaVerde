<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateOrgaosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_orgao' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome_orgao' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
                'unique' => true, // Nome do órgão deve ser único
            ],
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 4000,
                'null' => true, // Descrição pode ser opcional
                'default' => null,
            ],
            'telefone_contato' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true, // Telefone pode ser opcional
            ],
            'email_institucional' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'unique' => true, // Email institucional deve ser único
            ],
            'logradouro' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'bairro' => [
                'type' => 'VARCHAR',
                'constraint' => 125,
                'null' => false,
            ],
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'ponto_referencia' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
                'default' => null,
            ],
            'data_criacao' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'), // Padrão para a hora atual
            ],
            'data_edicao' => [
                'type' => 'TIMESTAMP',
                'null' => true, // Pode ser null no momento da criação
                'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('id_orgao');
        $this->forge->createTable('orgaos', true);

        // $this->db->table('orgaos')->insert([
        //     'nome_orgao' => 'Prefeitura Municipal de Ponta Grossa',
        //     'descricao' => 'Órgão responsável pela administração municipal.',
        //     'telefone_contato' => '(42) 3030-3030',
        //     'email_institucional' => 'contato@pmpg.gov.br',
        //     'logradouro' => 'Av Visconde Alguma Coisa',
        //     'numero' => '1000',
        //     'bairro' => 'Centro',
        //     'cep' => '84000-000',
        //     'ponto_referencia' => 'Ao lado da Camara Municipal',
        // ]);
    }

    public function down()
    {
        $this->forge->dropTable('orgaos', true);
    }
}