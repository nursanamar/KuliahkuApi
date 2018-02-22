<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_dosen extends CI_Migration
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
            'idDosen' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'noTelepon' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("idDosen", TRUE);

        // Table attributes.



        // Create Table dosen
        $this->dbforge->create_table("dosen", TRUE);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table dosen
        $this->dbforge->drop_table("dosen", TRUE);
    }

}
