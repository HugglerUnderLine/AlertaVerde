<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql; // Importe RawSql para CURRENT_TIMESTAMP

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
                'null' => true, // Endereço pode ser opcional inicialmente
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'bairro' => [
                'type' => 'VARCHAR',
                'constraint' => 125,
                'null' => true,
            ],
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'ponto_referencia' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'data_criacao' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'), // Padrão para a hora atual
            ],
            'data_edicao' => [
                'type' => 'TIMESTAMP',
                'null' => true, // Pode ser null no momento da criação
                'default' => new RawSql('CURRENT_TIMESTAMP'), // Padrão para a hora atual (será atualizado por trigger)
            ],
        ]);

        $this->forge->addPrimaryKey('id_orgao');
        $this->forge->createTable('orgaos', true); // Nome da tabela em minúsculas e plural

        // Opcional: Adicionar um órgão de exemplo se necessário para testes iniciais
        // $this->db->table('orgaos')->insert([
        //     'nome_orgao' => 'Prefeitura Municipal',
        //     'descricao' => 'Órgão responsável pela administração municipal.',
        //     'telefone_contato' => '(XX) XXXX-XXXX',
        //     'email_institucional' => 'contato@prefeitura.com.br',
        //     'logradouro' => 'Rua Principal',
        //     'numero' => '123',
        //     'bairro' => 'Centro',
        //     'cep' => '84000-000',
        //     'ponto_referencia' => 'Em frente à Praça Central',
        // ]);
    }

    public function down()
    {
        $this->forge->dropTable('orgaos', true);
    }
}