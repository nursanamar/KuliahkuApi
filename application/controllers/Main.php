<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Migration',null,'migrat');
  $this->load->model('jadwal_model');
		
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function login()
	{
		$response = array();
		$check = false;
		try {
		  $check = $this->validateLogin();
		} catch (Exception $e) {

		}
    if($check){
      $token = $this->generateToken();
      $response = array(
        'status' => 'ok',
        'desc' => "Login succes",
        'data' => array(
          'token' => $token,
          'user' => $this->user,
        ),
      );

    }else {
      $response = array(
        'status' => 'failed',
        'desc' => $e->getMessage(),
      );
    }
    $this->sendResponse($response);
	}

	public function generator($table)
	{
		$res = $this->login->getData($table);
		$this->sendResponse($res);
	}

	public function mahasiswa()
	{
		$data = $this->getBody();
		$user = array();
		$mahasiswa = array();
		foreach ($data as $value) {
			$user[] = array(
				"nim" => $value['nim'],
				"nama" => $value['nama'],
				"pass" => password_hash($value['pass'],PASSWORD_DEFAULT),
			);
			$mahasiswa[] = array(
				"nim" => $value['nim'],
				"mahasiswa" => $value['nama'],
				"idJadwal" => "JDL0002",
			);
		}
		$res['user'] = $this->login->getData('user',$user);
		$res['mahasiswa'] = $this->login->getData('mahasiswa',$mahasiswa);
		$this->sendResponse($res);
	}

	public function migrateTable()
	{
		$this->migrat->version('20171226015120');
		$this->migrat->version('20171226015622');
		$this->migrat->version('20171226021854');
		$this->migrat->version('20171226022016');
		$this->migrat->version('20180101093614');
		$this->migrat->version('20180219092922');
	}

	public function applyPatch()
	{
		$this->load->dbforge();
		$field = array(
			"isTemp" => array(
				"type" => "INT",
				"default" => 0
			)
		);

		$this->dbforge->add_column("kuliah",$field);

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
			"isTemp" => array(
					"type" => "INT",
					"default" => 0
			)
		));

		// Add Primary Key.
		$this->dbforge->add_key("idKuliah", true);

		// Table attributes.

		// Create Table kuliah
		$this->dbforge->create_table("kuliahTemp", true);

	}

	public function testClone($id)
	{
		$this->jadwal_model->cloneKuliah($id);
	}
}
