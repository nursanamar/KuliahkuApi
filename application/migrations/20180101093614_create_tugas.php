<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_tugas extends CI_Migration
{

    /**
     * up (create table)
     *
     * @return void
     */
    public function up()
    {

        // Add Fields.
        $this->dbforge->add_field(array(
            'idTugas' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'judul' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'desc' => array(
                'type' => 'VARCHAR',
                'constraint' => '1000',
            ),
            'mulai' => array(
                'type' => 'DATE',
            ),
            'sampai' => array(
                'type' => 'DATE',
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("idTugas", TRUE);

        // Table attributes.



        // Create Table tugas
        $this->dbforge->create_table("tugas", TRUE);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table tugas
        $this->dbforge->drop_table("tugas", TRUE);
    }

}
