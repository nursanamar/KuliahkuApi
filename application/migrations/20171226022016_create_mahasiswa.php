<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_mahasiswa extends CI_Migration
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
            'nim' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'mahasiswa' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'idJadwal' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("nim", TRUE);

        // Table attributes.



        // Create Table mahasiswa
        $this->dbforge->create_table("mahasiswa", TRUE);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table mahasiswa
        $this->dbforge->drop_table("mahasiswa", TRUE);
    }

}
