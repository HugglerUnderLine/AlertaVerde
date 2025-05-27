<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql; // Importe RawSql para CURRENT_TIMESTAMP

class CreateLogAuditoriaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'log_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_uuid' => [ // UUID do usuário que realizou a ação
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false,
            ],
            'user_email' => [ // E-mail do usuário no momento da ação
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'user_nome_completo' => [ // Nome completo do usuário no momento da ação
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'tipo_usuario' => [ // Tipo de usuário que realizou a ação (cidadao, orgao_master, admin)
                'type' => 'VARCHAR',
                'constraint' => 25,
                'null' => false,
            ],
            'user_action' => [ // Descrição da ação (ex: 'cadastrar_usuario', 'editar_denuncia')
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'user_ip' => [ // Endereço IP de onde a ação foi realizada
                'type' => 'VARCHAR',
                'constraint' => 45, // IPv4 pode ter até 15 caracteres, IPv6 até 45
                'null' => true, // Pode ser null se não for capturado ou para ações internas
            ],
            'detalhes' => [ // JSON completo das alterações, status, etc.
                'type' => 'JSONB',
                'null' => true, // Pode ser null para ações simples ou se não houver detalhes complexos
            ],
            'data_log' => [ // Data e hora do registro do log
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('log_id');
        $this->forge->createTable('log_auditoria', true);
    }

    public function down()
    {
        $this->forge->dropTable('log_auditoria', true);
    }
}