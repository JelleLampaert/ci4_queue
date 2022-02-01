<?php namespace jellelampaert\ci4_queue\Database\Migrations;

use CodeIgniter\Database\Migration;

class Queue_tables extends Migration
{
    public function up()
    {
        /*
         * Queue
         */
        $this->forge->addField([
            'id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'queue'     => ['type' => 'varchar', 'constraint' => 100],
            'data'      => ['type' => 'text'],
            'response'  => ['type' => 'text'],
            'created'   => ['type' => 'int', 'unsigned' => true],
            'processed' => ['type' => 'int', 'unsigned' => true, 'default' => 0]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('queue', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('queue', true);
    }
}