<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_kuliah extends CI_Migration
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
            'idKuliah' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'idMatkul' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'hari' => array(
                'type' => 'VARCHAR',
                'constraint' => '11',
            ),
            'jam' => array(
                'type' => 'TIME',
            ),
            'ruangan' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'idDosen' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'idTugas' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => '12',
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("idKuliah", TRUE);

        // Table attributes.



        // Create Table kuliah
        $this->dbforge->create_table("kuliah", TRUE);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table kuliah
        $this->dbforge->drop_table("kuliah", TRUE);
    }

}
