<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_user extends CI_Migration
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
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'pass' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table user
        $this->dbforge->create_table("user", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table user
        $this->dbforge->drop_table("user", TRUE);
    }

}
