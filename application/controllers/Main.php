<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Migration',null,'migrat');

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

	public function welcome()
	{
		echo "<h1 align='center'>. . . . . .</h1>";
	}

	public function feedData($table)
	{
		$data = $this->getBody();
		$res['status'] = $this->login->feedData($table,$data);
		$this->sendResponse($res);
	}

	public function getData($table)
	{
		$data = $this->login->getData($table);
		$this->sendResponse($data);
	}

	public function editData($tabel,$id)
	{
		$data = $this->getBody();
		$res['update'] = $this->login->update($table,$id,$data);
		$this->sendResponse($res);

	}

	public function fixJadwal($idJadwal)
	{
		$res = $this->login->getData($table);
		$this->sendResponse($res);
	}

	public function getMahasiswa()
	{
		$data["user"] = $this->login->getData('user'); 
		$data["mahasiswa"] = $this->login->getData('mahasiswa'); 
		$this->sendResponse($data);
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
				"idJadwal" => "JDL0003",
			);
		}
		$res['user'] = $this->login->feedData('user',$user);
		$res['mahasiswa'] = $this->login->feedData('mahasiswa',$mahasiswa);
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
}
