<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_jadwal extends CI_Migration
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
            'idJadwal' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'idKuliah' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table jadwal
        $this->dbforge->create_table("jadwal", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table jadwal
        $this->dbforge->drop_table("jadwal", TRUE);
    }

}
