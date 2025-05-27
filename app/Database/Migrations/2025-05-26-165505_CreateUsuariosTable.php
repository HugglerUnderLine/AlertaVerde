<?php

namespace App\Database\Migrations;

use App\Models\UsuarioModel; // Assumindo que você tem um modelo para gerar UUIDs
use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_usuario' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 36, // UUIDs são tipicamente 36 caracteres (32 hex + 4 hífens)
                'null' => false,
                'unique' => true,
            ],
            'nome_completo' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'unique' => true, // O email deve ser único para login
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => 256, // Tamanho adequado para hash bcrypt
                'null' => false,
            ],
            'tipo_usuario' => [
                // Poderíamos usar ENUM para PostgreSQL para garantir os valores,
                // mas VARCHAR com constraint no modelo ou validação na aplicação é comum.
                // Valores: 'cidadao', 'orgao_master', 'orgao_representante', 'admin'
                'type' => 'VARCHAR',
                'constraint' => 25, // Ajustado para 'orgao_representante' (19 caracteres) + margem
                'null' => false,
            ],
            'id_orgao_fk' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true, // Este campo é opcional, pois cidadãos e admins não pertencem a um órgão
            ],
            'ativo' => [
                'type' => 'INT', // Para 1 ou 0, INT é mais comum que BOOLEAN em migrations para compatibilidade ampla
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
                'null' => true, // Pode ser null no momento da criação e atualizado depois
                'default' => new RawSql('CURRENT_TIMESTAMP'), // Padrão para ser a data de criação/edição inicial
            ],
        ]);

        $this->forge->addPrimaryKey('id_usuario');

        // Adiciona a chave estrangeira para a tabela 'orgaos'
        // É importante que a tabela 'orgaos' seja criada ANTES desta migration ou em uma migration anterior.
        $this->forge->addForeignKey('id_orgao_fk', 'orgaos', 'id_orgao', 'CASCADE', 'SET NULL');
        // 'CASCADE' para ON UPDATE: se o id_orgao na tabela 'orgaos' for atualizado, o id_orgao_fk aqui também será.
        // 'SET NULL' para ON DELETE: se um órgão for deletado, os usuários associados a ele terão id_orgao_fk setado para NULL.

        $this->forge->createTable('usuarios', true); // Mudando o nome da tabela para 'usuarios' (minúsculas é convenção)

        // Criação de usuário padrão (ADMIN)
        // Certifique-se de que App\Models\UsuarioModel exista e tenha o método generateUUID()
        $usuarioModel = new UsuarioModel();

        $this->db->table('usuarios')->insert([
            'user_uuid' => $usuarioModel->generateUUID(),
            'nome_completo' => 'SYS Admin',
            'email' => 'admin@alertaverde.com.br',
            'senha' => password_hash('adminroot', PASSWORD_BCRYPT),
            'tipo_usuario' => 'admin',
            'ativo' => 1, // Use 1 para ativo
            // 'id_orgao_fk' será NULL por padrão para admins
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('usuarios', true);
    }
}