<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql; // Importe RawSql para CURRENT_TIMESTAMP

class CreateDenunciasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_denuncia' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_usuario_fk' => [ // Cidadão que fez a denúncia
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'id_tipo_fk' => [ // Tipo da denúncia (Meio Ambiente, etc.)
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'titulo_denuncia' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'detalhes' => [
                'type' => 'VARCHAR',
                'constraint' => 4000,
                'null' => false,
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
            ],
            'latitude' => [
                'type' => 'NUMERIC',
                'constraint' => '9,6',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'NUMERIC',
                'constraint' => '9,6',
                'null' => true,
            ],
            'status_denuncia' => [
                // Valores: 'Pendente', 'Em Atendimento', 'Concluída', 'Recusada'
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
                'default' => 'Pendente', // Status inicial ao submeter uma denúncia
            ],
            'id_orgao_responsavel_fk' => [ // Órgão que assumiu a denúncia
                'type' => 'INT',
                'unsigned' => true,
                'null' => true, // Null se ainda não atribuída
            ],
            'id_usuario_responsavel_fk' => [ // Representante específico do órgão
                'type' => 'INT',
                'unsigned' => true,
                'null' => true, // Null se não atribuída a um representante
            ],
            'data_submissao' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'data_atribuicao' => [
                'type' => 'TIMESTAMP',
                'null' => true, // Null inicialmente, preenchido quando atribuída
                'default' => null,
            ],
            'data_conclusao' => [
                'type' => 'TIMESTAMP',
                'null' => true, // Null inicialmente, preenchido quando concluída
                'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('id_denuncia');

        // Depende de 'usuarios'
        $this->forge->addForeignKey('id_usuario_fk', 'usuarios', 'id_usuario', 'CASCADE', 'RESTRICT');
        // 'CASCADE' para ON DELETE: se o usuário que fez a denúncia for deletado, a denúncia também será (ou 'RESTRICT' se preferir evitar).
        // 'RESTRICT' para ON UPDATE: impede a atualização do id_usuario na tabela 'usuarios' se houver denúncias associadas.

        // Depende de 'tipo_denuncia'
        $this->forge->addForeignKey('id_tipo_fk', 'tipo_denuncia', 'id_tipo', 'RESTRICT', 'RESTRICT');
        // 'RESTRICT' para ON DELETE: impede a exclusão de um tipo de denúncia se houver denúncias associadas a ele.
        // 'RESTRICT' para ON UPDATE: impede a atualização do id_tipo na tabela 'tipo_denuncia' se houver denúncias associadas.

        // Depende de 'orgaos' para o órgão responsável
        $this->forge->addForeignKey('id_orgao_responsavel_fk', 'orgaos', 'id_orgao', 'SET NULL', 'SET NULL');
        // 'SET NULL' para ON DELETE: se o órgão responsável for deletado, este FK vira NULL.
        // 'SET NULL' para ON UPDATE: se o id do órgão for alterado, este FK vira NULL (ou CASCADE se preferir).

        // Depende de 'usuarios' para o representante do órgão
        $this->forge->addForeignKey('id_usuario_responsavel_fk', 'usuarios', 'id_usuario', 'SET NULL', 'SET NULL');
        // 'SET NULL' para ON DELETE: se o representante for deletado, este FK vira NULL.
        // 'SET NULL' para ON UPDATE: se o id do usuário for alterado, este FK vira NULL (ou CASCADE).


        $this->forge->createTable('denuncias', true);
    }

    public function down()
    {
        $this->forge->dropTable('denuncias', true);
    }
}