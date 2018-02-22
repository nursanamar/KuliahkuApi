<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_matkul extends CI_Migration
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
            'idMatkul' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'semester' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("idMatkul", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table matkul
        $this->dbforge->create_table("matkul", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table matkul
        $this->dbforge->drop_table("matkul", TRUE);
    }

}
